<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // GET /api/reviews - Get all approved reviews
    public function index()
    {
        $reviews = Review::approved()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($reviews, 200);
    }

    // GET /api/reviews/{type}/{itemId} - Get reviews for specific item
    public function getByItem($type, $itemId)
    {
        $reviews = Review::where('reviewable_type', $type)
            ->where('reviewable_id', $itemId)
            ->approved()
            ->with('user')
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews, 200);
    }

    // POST /api/reviews - Create review
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => 'required|in:App\Models\Trip,App\Models\Destination',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        // Check if user already reviewed this item
        $exists = Review::where('user_id', $user->id)
            ->where('reviewable_type', $validated['reviewable_type'])
            ->where('reviewable_id', $validated['reviewable_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'You already reviewed this item'], 409);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'reviewable_type' => $validated['reviewable_type'],
            'reviewable_id' => $validated['reviewable_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'pending',
        ]);

        return response()->json($review, 201);
    }

    // PUT /api/reviews/{id} - Update review
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|nullable|string|max:1000',
            'status' => 'sometimes|in:pending,approved,rejected',
        ]);

        $review->update($validated);
        return response()->json($review, 200);
    }

    // DELETE /api/reviews/{id} - Delete review
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('delete', $review);

        $review->delete();
        return response()->json(['message' => 'Review deleted'], 200);
    }
}
