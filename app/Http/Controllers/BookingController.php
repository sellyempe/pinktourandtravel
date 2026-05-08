<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use App\Services\BookingService;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Access\Gate;

class BookingController extends Controller
{
    protected $bookingService;
    protected $midtransService;

    public function __construct(BookingService $bookingService, MidtransService $midtransService)
    {
        $this->bookingService = $bookingService;
        $this->midtransService = $midtransService;
    }

    /**
     * Show booking form untuk trip
     */
    public function create($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        // Di awal belum ada tanggal dipilih, jadi kita lempar kuota maksimal
        $availableSeats = $trip->kuota;

        return view('booking.create', [
            'trip' => $trip,
            'availableSeats' => $availableSeats,
        ]);
    }

    /**
     * Store booking baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'participants' => 'required|integer|min:1',
            'preferred_date' => 'required|date|after_or_equal:today',
            'phone' => 'required|string|min:10|max:15',
            'special_request' => 'nullable|string|max:500',
        ]);

        try {
            $booking = $this->bookingService->createBooking(
                auth()->id(),
                $validated['trip_id'],
                $validated['participants'],
                $validated
            );

            return redirect()->route('booking.confirmation', $booking->id);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Cek ketersediaan kursi via AJAX
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'date' => 'required|date'
        ]);

        $availableSeats = $this->bookingService->getAvailableSeatsForDate($request->trip_id, $request->date);

        return response()->json([
            'available_seats' => $availableSeats
        ]);
    }


    /**
     * Show booking confirmation page
     */
    public function confirmation($bookingId)
    {
        $booking = Booking::with(['trip', 'user'])->findOrFail($bookingId);

        // Pastikan user yang akses adalah pemilik booking
        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Unauthorized');
        }

        // Generate Snap Token
        try {
            $snapToken = $this->midtransService->createSnapToken($booking);
        } catch (\Exception $e) {
            \Log::error('Failed to generate Snap token: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat token pembayaran. Silakan coba lagi.');
        }

        return view('booking.confirmation', [
            'booking' => $booking,
            'snapToken' => $snapToken,
            'clientKey' => config('midtrans.client_key'),
            'snapUrl' => config('midtrans.snap_url'),
        ]);
    }

    /**
     * Handle notifikasi dari Midtrans.
     * Verifikasi signature dilakukan pertama kali untuk mencegah notifikasi palsu.
     */
    public function handleNotification(Request $request)
    {
        $notification = $request->all();

        try {
            // Verifikasi signature key dari Midtrans sebelum memproses apapun
            $this->midtransService->verifySignature($notification);

            $result  = $this->midtransService->handleNotification($notification);
            $orderId = $result['order_id'];
            $status  = $result['status'];

            // Cari booking berdasarkan order_id
            $booking = Booking::where('order_id', $orderId)->firstOrFail();

            DB::transaction(function () use ($booking, $status) {
                if ($status === 'success' && $booking->status === 'pending') {
                    $this->bookingService->confirmBooking($booking);
                } elseif ($status === 'failed' && $booking->status === 'pending') {
                    $booking->update(['status' => 'cancelled']);
                }
            });

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 400);
        }
    }

    /**
     * Show user's bookings
     */
    public function index()
    {
        $bookings = auth()->user()->bookings()->with('trip')->orderBy('created_at', 'desc')->get();
        return view('booking.index', ['bookings' => $bookings]);
    }

    /**
     * Dashboard user — ringkasan booking dan statistik
     */
    public function userDashboard()
    {
        $user     = auth()->user();
        $bookings = $user->bookings()->with('trip')->latest()->get();

        $stats = [
            'total'     => $bookings->count(),
            'pending'   => $bookings->where('status', 'pending')->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'completed' => $bookings->where('status', 'completed')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        $recentBookings = $bookings->take(5);

        return view('user.dashboard', compact('user', 'stats', 'recentBookings'));
    }

    /**
     * Show booking detail
     */
    public function show($bookingId)
    {
        $booking = Booking::with(['trip', 'user', 'paymentTransaction'])->findOrFail($bookingId);

        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Unauthorized');
        }

        $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
            ->where('reviewable_type', 'App\Models\Trip')
            ->where('reviewable_id', $booking->trip_id)
            ->exists();

        return view('booking.show', ['booking' => $booking, 'hasReviewed' => $hasReviewed]);
    }

    /**
     * Cancel booking.
     * Hanya booking dengan status 'pending' atau 'confirmed' yang dapat dibatalkan.
     */
    public function cancel($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if (auth()->id() !== $booking->user_id) {
            abort(403, 'Unauthorized');
        }

        // Batasi pembatalan hanya untuk status pending/confirmed
        if (! in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Booking dengan status "' . $booking->status . '" tidak dapat dibatalkan.');
        }

        try {
            $this->bookingService->cancelBooking($booking);
            return back()->with('success', 'Booking berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}