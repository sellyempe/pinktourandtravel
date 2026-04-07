<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Trip;
use App\Models\Destination;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // GET /api/wishlists - Get user's wishlists
    public function index()
    {
        $user = auth()->user();
        $wishlists = $user->wishlists()->with('wishlistable')->get();
        return response()->json($wishlists, 200);
    }

    // POST /api/wishlists - Add to wishlist
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wishlistable_type' => 'required|in:App\Models\Trip,App\Models\Destination',
            'wishlistable_id' => 'required|integer',
        ]);

        $user = auth()->user();

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('wishlistable_type', $validated['wishlistable_type'])
            ->where('wishlistable_id', $validated['wishlistable_id'])
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already in wishlist'], 409);
        }

        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'wishlistable_type' => $validated['wishlistable_type'],
            'wishlistable_id' => $validated['wishlistable_id'],
        ]);

        return response()->json($wishlist, 201);
    }

    // DELETE /api/wishlists/{id} - Remove from wishlist
    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $this->authorize('delete', $wishlist);
        
        $wishlist->delete();
        return response()->json(['message' => 'Removed from wishlist'], 200);
    }

    // DELETE /api/wishlists/item/{type}/{itemId} - Remove by type and item
    public function destroyByItem($type, $itemId)
    {
        $user = auth()->user();
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('wishlistable_type', $type)
            ->where('wishlistable_id', $itemId)
            ->firstOrFail();

        $wishlist->delete();
        return response()->json(['message' => 'Removed from wishlist'], 200);
    }

    // GET /api/wishlists/check/{type}/{itemId} - Check if in wishlist
    public function check($type, $itemId)
    {
        $user = auth()->user();
        $exists = Wishlist::where('user_id', $user->id)
            ->where('wishlistable_type', $type)
            ->where('wishlistable_id', $itemId)
            ->exists();

        return response()->json(['in_wishlist' => $exists], 200);
    }
}
