<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    // GET /trip/{id} - Show trip detail page
    public function detail($id)
    {
        $trip = Trip::with(['itineraries', 'includes', 'excludes'])->findOrFail($id);
        
        $canReview = false;
        if (auth()->check()) {
            $hasCompletedBooking = \App\Models\Booking::where('user_id', auth()->id())
                ->where('trip_id', $id)
                ->where('status', 'completed')
                ->exists();
                
            $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                ->where('reviewable_type', 'App\Models\Trip')
                ->where('reviewable_id', $id)
                ->exists();
                
            $canReview = $hasCompletedBooking && !$hasReviewed;
        }

        return view('trip.detail', ['trip' => $trip, 'canReview' => $canReview]);
    }

    // GET /api/trips - Ambil semua trips
    public function index()
    {
        return response()->json(Trip::all());
    }

    // GET /api/trips/{id} - Ambil satu trip dengan itineraries, includes, excludes
    public function show($id)
    {
        $trip = Trip::with(['itineraries', 'includes', 'excludes'])->findOrFail($id);
        return response()->json($trip);
    }

    // POST /api/trips - Create baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'departure_city' => 'required|string',
            'destination' => 'required|string',
            'meeting_point' => 'required|string',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
        ]);

        $trip = Trip::create($validated);
        return response()->json($trip, 201);
    }

    // PUT /api/trips/{id} - Update
    public function update(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'departure_city' => 'string',
            'destination' => 'string',
            'meeting_point' => 'string',
            'price' => 'numeric',
            'duration_days' => 'integer',
        ]);

        $trip->update($validated);
        return response()->json($trip);
    }

    // DELETE /api/trips/{id} - Hapus
    public function destroy($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();
        return response()->json(null, 204);
    }
}