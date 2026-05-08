<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use App\Models\TripItinerary;
use App\Models\TripInclude;
use App\Models\TripExclude;
use App\Models\Destination;
use App\Models\CompanySetting;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ─── Helper ──────────────────────────────────────────────────────────────

    /**
     * Simpan file gambar ke storage dan kembalikan path-nya.
     * Jika ada gambar lama, hapus dulu.
     */
    private function handleImageUpload(Request $request, string $field, ?string $oldPath = null): ?string
    {
        if (!$request->hasFile($field)) {
            return $oldPath; // tidak ada upload baru, kembalikan path lama
        }

        // Hapus gambar lama jika ada
        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        $file = $request->file($field);
        return $file->store('images/' . $field . 's', 'public');
    }

    // ======== TRIPS ========

    public function dashboard()
    {
        $trips  = Trip::withCount('bookings')->latest()->get();
        $counts = [
            'trips'        => Trip::count(),
            'destinations' => Destination::count(),
            'bookings'     => Booking::count(),
            'pending'      => Booking::where('status', 'pending')->count(),
        ];
        return view('admin.dashboard', compact('trips', 'counts'));
    }

    public function createTrip()
    {
        return view('admin.trips.create');
    }

    public function storeTrip(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'overview'        => 'required|string',
            'departure_city'  => 'required|string|max:100',
            'destination'     => 'required|string|max:100',
            'meeting_point'   => 'required|string',
            'meeting_address' => 'required|string',
            'price'           => 'required|numeric|min:0',
            'duration_days'   => 'required|integer|min:1',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'          => 'required|in:active,inactive',
            'kuota'           => 'required|integer|min:1',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
        ]);

        // Handle file upload
        $imagePath = $this->handleImageUpload($request, 'image');
        $validated['image'] = $imagePath ? Storage::url($imagePath) : null;

        $trip = Trip::create($validated);

        // Itineraries
        if ($request->has('itineraries')) {
            foreach ($request->itineraries as $itinerary) {
                if (empty($itinerary['title'])) continue;
                TripItinerary::create([
                    'trip_id'     => $trip->id,
                    'day_number'  => $itinerary['day_number'],
                    'title'       => $itinerary['title'],
                    'description' => $itinerary['description'] ?? '',
                    'activities'  => [],
                ]);
            }
        }

        // Includes
        if ($request->has('includes')) {
            foreach ($request->includes as $include) {
                if (empty($include['item_name'])) continue;
                TripInclude::create([
                    'trip_id'   => $trip->id,
                    'item_name' => $include['item_name'],
                    'category'  => $include['category'] ?? '',
                ]);
            }
        }

        // Excludes
        if ($request->has('excludes')) {
            foreach ($request->excludes as $exclude) {
                if (empty($exclude['item_name'])) continue;
                TripExclude::create([
                    'trip_id'   => $trip->id,
                    'item_name' => $exclude['item_name'],
                    'category'  => $exclude['category'] ?? '',
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Trip "' . $trip->title . '" berhasil ditambahkan!');
    }

    public function editTrip($id)
    {
        $trip = Trip::with(['itineraries', 'includes', 'excludes'])->findOrFail($id);
        return view('admin.trips.edit', compact('trip'));
    }

    public function updateTrip(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'overview'        => 'required|string',
            'departure_city'  => 'required|string|max:100',
            'destination'     => 'required|string|max:100',
            'meeting_point'   => 'required|string',
            'meeting_address' => 'required|string',
            'price'           => 'required|numeric|min:0',
            'duration_days'   => 'required|integer|min:1',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'          => 'required|in:active,inactive',
            'kuota'           => 'required|integer|min:1',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
        ]);

        // Ambil path lama dari URL storage
        $oldPath = null;
        if ($trip->image && str_contains($trip->image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', parse_url($trip->image, PHP_URL_PATH));
        }

        $imagePath = $this->handleImageUpload($request, 'image', $oldPath);
        if ($request->hasFile('image')) {
            $validated['image'] = Storage::url($imagePath);
        } else {
            unset($validated['image']); // jaga gambar lama
        }

        $trip->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Trip "' . $trip->title . '" berhasil diperbarui!');
    }

    public function destroyTrip($id)
    {
        $trip = Trip::findOrFail($id);

        // Hapus gambar dari storage
        if ($trip->image && str_contains($trip->image, '/storage/')) {
            $path = str_replace('/storage/', '', parse_url($trip->image, PHP_URL_PATH));
            Storage::disk('public')->delete($path);
        }

        $trip->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Trip berhasil dihapus.');
    }

    // ======== DESTINATIONS ========

    public function destinationsDashboard()
    {
        $destinations = Destination::latest()->get();
        return view('admin.destinations.dashboard', compact('destinations'));
    }

    public function createDestination()
    {
        return view('admin.destinations.create');
    }

    public function storeDestination(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'interesting_fact' => 'required|string',
            'category'         => 'required|string',
            'location'         => 'required|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'           => 'required|in:active,inactive',
        ]);

        $imagePath = $this->handleImageUpload($request, 'image');
        $validated['image'] = $imagePath ? Storage::url($imagePath) : null;

        Destination::create($validated);
        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function editDestination($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', compact('destination'));
    }

    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'required|string',
            'interesting_fact' => 'required|string',
            'category'         => 'required|string',
            'location'         => 'required|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status'           => 'required|in:active,inactive',
        ]);

        $oldPath = null;
        if ($destination->image && str_contains($destination->image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', parse_url($destination->image, PHP_URL_PATH));
        }

        $imagePath = $this->handleImageUpload($request, 'image', $oldPath);
        if ($request->hasFile('image')) {
            $validated['image'] = Storage::url($imagePath);
        } else {
            unset($validated['image']);
        }

        $destination->update($validated);
        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil diperbarui!');
    }

    public function destroyDestination($id)
    {
        $destination = Destination::findOrFail($id);

        if ($destination->image && str_contains($destination->image, '/storage/')) {
            $path = str_replace('/storage/', '', parse_url($destination->image, PHP_URL_PATH));
            Storage::disk('public')->delete($path);
        }

        $destination->delete();
        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil dihapus.');
    }

    // ======== SETTINGS ========

    public function settingsDashboard()
    {
        $settings = CompanySetting::all();
        return view('admin.settings.dashboard', compact('settings'));
    }

    public function editSetting($id)
    {
        $setting = CompanySetting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function updateSetting(Request $request, $id)
    {
        $setting = CompanySetting::findOrFail($id);
        $validated = $request->validate([
            'value' => 'required|string',
            'type'  => 'required|in:string,number,text,boolean,json',
        ]);
        $setting->update($validated);
        return redirect()->route('admin.settings.dashboard')->with('success', 'Pengaturan berhasil diperbarui.');
    }

    // ======== REVIEWS ========

    public function reviewsDashboard()
    {
        $status = request('status', 'all');
        $allReviews      = Review::with('user', 'reviewable')->latest()->get();
        $pendingReviews  = $allReviews->where('status', 'pending');
        $approvedReviews = $allReviews->where('status', 'approved');
        $rejectedReviews = $allReviews->where('status', 'rejected');

        $reviews = match ($status) {
            'pending'  => $pendingReviews,
            'approved' => $approvedReviews,
            'rejected' => $rejectedReviews,
            default    => $allReviews,
        };

        return view('admin.reviews.dashboard', compact('reviews', 'allReviews', 'pendingReviews', 'approvedReviews', 'rejectedReviews'));
    }

    public function approveReview($id)
    {
        Review::findOrFail($id)->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Review disetujui.');
    }

    public function rejectReview($id)
    {
        Review::findOrFail($id)->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Review ditolak.');
    }

    // ======== BOOKINGS ========

    public function bookingsDashboard()
    {
        $status   = request('status', 'all');
        $query    = Booking::with(['user', 'trip'])->latest();
        if ($status !== 'all') $query->where('status', $status);
        $bookings = $query->paginate(20)->withQueryString();
        $counts   = Booking::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.bookings.dashboard', compact('bookings', 'counts', 'status'));
    }

    public function completeBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Hanya booking terkonfirmasi yang dapat diselesaikan.');
        }
        $booking->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Booking #' . $booking->order_id . ' ditandai selesai.');
    }
}