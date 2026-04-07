<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripItinerary;
use App\Models\TripInclude;
use App\Models\TripExclude;
use App\Models\Destination;
use App\Models\CompanySetting;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // ======== TRIPS ========
    
    // Admin Dashboard - List all trips
    public function dashboard()
    {
        $trips = Trip::all();
        return view('admin.dashboard', ['trips' => $trips]);
    }

    // Show create form for trip
    public function createTrip()
    {
        return view('admin.trips.create');
    }

    // Store new trip
    public function storeTrip(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'required|string',
            'departure_city' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'meeting_point' => 'required|string',
            'meeting_address' => 'required|string',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
            'image' => 'required|url',
            'status' => 'required|in:active,inactive',
        ]);

        $trip = Trip::create($validated);

        // Create itineraries
        if ($request->has('itineraries')) {
            foreach ($request->itineraries as $itinerary) {
                TripItinerary::create([
                    'trip_id' => $trip->id,
                    'day_number' => $itinerary['day_number'],
                    'title' => $itinerary['title'],
                    'description' => $itinerary['description'] ?? '',
                    'activities' => [],
                ]);
            }
        }

        // Create includes
        if ($request->has('includes')) {
            foreach ($request->includes as $include) {
                TripInclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $include['item_name'],
                    'category' => $include['category'],
                ]);
            }
        }

        // Create excludes
        if ($request->has('excludes')) {
            foreach ($request->excludes as $exclude) {
                TripExclude::create([
                    'trip_id' => $trip->id,
                    'item_name' => $exclude['item_name'],
                    'category' => $exclude['category'],
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Trip berhasil ditambahkan');
    }

    // Show edit form for trip
    public function editTrip($id)
    {
        $trip = Trip::findOrFail($id);
        return view('admin.trips.edit', ['trip' => $trip]);
    }

    // Update trip
    public function updateTrip(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'overview' => 'required|string',
            'departure_city' => 'required|string|max:100',
            'destination' => 'required|string|max:100',
            'meeting_point' => 'required|string',
            'meeting_address' => 'required|string',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
            'image' => 'required|url',
            'status' => 'required|in:active,inactive',
        ]);

        $trip->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Trip berhasil diupdate');
    }

    // Delete trip
    public function destroyTrip($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Trip berhasil dihapus');
    }

    // ======== DESTINATIONS ========
    
    // Destinations Dashboard - List all destinations
    public function destinationsDashboard()
    {
        $destinations = Destination::all();
        return view('admin.destinations.dashboard', ['destinations' => $destinations]);
    }

    // Show create form for destination
    public function createDestination()
    {
        return view('admin.destinations.create');
    }

    // Store new destination
    public function storeDestination(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'image' => 'required|url',
            'status' => 'required|in:active,inactive',
        ]);

        Destination::create($validated);

        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil ditambahkan');
    }

    // Show edit form for destination
    public function editDestination($id)
    {
        $destination = Destination::findOrFail($id);
        return view('admin.destinations.edit', ['destination' => $destination]);
    }

    // Update destination
    public function updateDestination(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'image' => 'required|url',
            'status' => 'required|in:active,inactive',
        ]);

        $destination->update($validated);

        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil diupdate');
    }

    // Delete destination
    public function destroyDestination($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();

        return redirect()->route('admin.destinations.dashboard')->with('success', 'Destinasi berhasil dihapus');
    }

    // ======== SETTINGS ========

    public function settingsDashboard()
    {
        return view('admin.settings.dashboard');
    }

    public function editSetting($id)
    {
        $setting = CompanySetting::findOrFail($id);
        return view('admin.settings.edit', ['setting' => $setting]);
    }

    public function updateSetting(Request $request, $id)
    {
        $setting = CompanySetting::findOrFail($id);

        $validated = $request->validate([
            'value' => 'required|string',
            'type' => 'required|in:string,number,text,boolean,json',
        ]);

        $setting->update($validated);
        return redirect()->route('admin.settings.dashboard')->with('success', 'Pengaturan berhasil diperbarui');
    }

    // ======== REVIEWS ========

    public function reviewsDashboard()
    {
        $status = request('status', 'all');
        
        $query = Review::with('user', 'reviewable');
        
        if ($status === 'pending') {
            $query->where('status', 'pending');
        } elseif ($status === 'approved') {
            $query->where('status', 'approved');
        } elseif ($status === 'rejected') {
            $query->where('status', 'rejected');
        }
        
        $reviews = $query->latest()->get();
        
        return view('admin.reviews.dashboard', [
            'reviews' => $reviews,
            'allReviews' => Review::all(),
            'pendingReviews' => Review::where('status', 'pending')->get(),
            'approvedReviews' => Review::where('status', 'approved')->get(),
            'rejectedReviews' => Review::where('status', 'rejected')->get(),
        ]);
    }

    public function approveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Review approved');
    }

    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Review rejected');
    }
}
