<x-mail::message>
# Booking Confirmed! 🎉

Hi {{ $user->name }},

Your booking has been confirmed! Get ready for an amazing trip experience.

**Trip Details:**
- **Title:** {{ $trip->title }}
- **Duration:** {{ $trip->duration_days }} Days
- **Meeting Point:** {{ $trip->meeting_point }}
- **Date:** To be confirmed

**Booking Details:**
- **Order ID:** {{ $booking->order_id }}
- **Participants:** {{ $booking->participants }} people
- **Total Price:** Rp {{ number_format($booking->total_price, 0, ',', '.') }}
- **Status:** Confirmed ✓

<x-mail::button :url="route('booking.show', $booking->id)">
View Booking Details
</x-mail::button>

**Important Information:**
- Your booking is confirmed and waiting for your presence on the scheduled date
- @if($booking->preferred_date) Your preferred date: {{ $booking->preferred_date->format('d M Y') }} @endif
- Contact us if you have any questions

Thank you for choosing PinkTravel! We look forward to giving you an unforgettable experience.

Best regards,<br>
{{ config('app.name') }} Team
</x-mail::message>
