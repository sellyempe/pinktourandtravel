<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    // Page Routes - untuk navigasi antar page di web.php
    
    public function show($id)
    {
        $destination = Destination::findOrFail($id);
        return view('destination.detail', compact('destination'));
    }

    // API Routes - untuk CRUD di api.php
    
    // GET /api/destinations - Ambil semua destinasi
    public function index()
    {
        return response()->json(Destination::all(), 200);
    }

    // GET /api/destinations/{id} - Ambil satu destinasi
    public function getDetail($id)
    {
        $destination = Destination::findOrFail($id);
        return response()->json($destination, 200);
    }

    // POST /api/destinations - Buat destinasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'interesting_fact' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|string',
            'location' => 'required|string'
        ]);

        $destination = Destination::create($validated);
        return response()->json($destination, 201);
    }

    // PUT /api/destinations/{id} - Update destinasi
    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'interesting_fact' => 'sometimes|required|string',
            'category' => 'sometimes|required|string',
            'image' => 'sometimes|nullable|string',
            'location' => 'sometimes|required|string'
        ]);

        $destination->update($validated);
        return response()->json($destination, 200);
    }

    // DELETE /api/destinations/{id} - Hapus destinasi
    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return response()->json(['message' => 'Destination deleted'], 200);
    }
}
