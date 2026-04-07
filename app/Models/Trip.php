<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = [
        'title',
        'description',
        'overview',
        'departure_city',
        'destination',
        'meeting_point',
        'meeting_address',
        'price',
        'duration_days',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relations
    public function itineraries()
    {
        return $this->hasMany(TripItinerary::class);
    }

    public function includes()
    {
        return $this->hasMany(TripInclude::class);
    }

    public function excludes()
    {
        return $this->hasMany(TripExclude::class);
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function approvedReviews()
    {
        return $this->reviews()->approved();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

