<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Trip;
use App\Mail\BookingConfirmed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingService
{
    /**
     * Buat booking baru
     */
    public function createBooking($userId, $tripId, $participants, $additionalData = [])
    {
        return DB::transaction(function () use ($userId, $tripId, $participants, $additionalData) {
            $trip = Trip::lockForUpdate()->findOrFail($tripId);

            // Validasi kuota
            $availableSeats = $trip->kuota - $trip->booked;
            if ($participants > $availableSeats) {
                throw new \Exception("Hanya tersisa {$availableSeats} kursi yang tersedia.");
            }

            // Hitung total harga
            $totalPrice = $trip->price * $participants;

            // Generate Order ID
            $timestamp = time();
            $orderIdBase = "PINK-{$tripId}-{$timestamp}";
            
            // Cek uniqueness order_id
            $orderCount = Booking::where('order_id', 'like', $orderIdBase . '%')->count();
            $orderId = $orderIdBase . ($orderCount > 0 ? '-' . ($orderCount + 1) : '');

            // Buat booking
            $booking = Booking::create([
                'user_id' => $userId,
                'trip_id' => $tripId,
                'participants' => $participants,
                'total_price' => $totalPrice,
                'order_id' => $orderId,
                'status' => 'pending',
                'preferred_date' => $additionalData['preferred_date'] ?? null,
                'phone' => $additionalData['phone'] ?? null,
                'special_request' => $additionalData['special_request'] ?? null,
            ]);

            return $booking;
        });
    }

    /**
     * Konfirmasi booking setelah pembayaran sukses
     */
    public function confirmBooking($booking)
    {
        return DB::transaction(function () use ($booking) {
            // Update booking status
            $booking->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            // Update kuota trip
            $trip = $booking->trip;
            $trip->increment('booked', $booking->participants);

            // Send confirmation email
            try {
                Mail::send(new BookingConfirmed($booking));
            } catch (\Exception $e) {
                // Log email sending error but don't fail the transaction
                \Log::warning('Failed to send booking confirmation email', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return $booking;            return $booking;
        });
    }

    /**
     * Batalkan booking
     */
    public function cancelBooking($booking)
    {
        return DB::transaction(function () use ($booking) {
            // Jika sudah confirmed, kurangi kuota
            if ($booking->status === 'confirmed') {
                $booking->trip->decrement('booked', $booking->participants);
            }

            $booking->update(['status' => 'cancelled']);

            return $booking;
        });
    }

    /**
     * Get available seats untuk trip
     */
    public function getAvailableSeats($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        return $trip->kuota - $trip->booked;
    }
}
