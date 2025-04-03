<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ratingCoffeeShop;
use Illuminate\Http\Request;

class RatingCoffeeShopController extends Controller
{
    /**
     * Get all ratings for a specific coffee shop
     */
    public function getByCoffeeShop($coffeeShopId)
    {
        $ratings = ratingCoffeeShop::with('user')
            ->where('coffee_shop_id', $coffeeShopId)
            ->where('show', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $ratings
        ]);
    }

    /**
     * Create a new rating
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'coffee_shop_id' => 'required|exists:coffee_shops,id',
            'comment' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        // Check if user has already rated this coffee shop
        $existingRating = ratingCoffeeShop::where('user_id', $validated['user_id'])
            ->where('coffee_shop_id', $validated['coffee_shop_id'])
            ->where('show', true)
            ->first();

        if ($existingRating) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already rated this coffee shop'
            ], 400);
        }

        $validated['show'] = true;
        $rating = ratingCoffeeShop::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Rating created successfully',
            'data' => $rating
        ], 201);
    }

    /**
     * Update a rating
     */
    public function update(Request $request, $id)
    {
        $rating = ratingCoffeeShop::where('show', true)->findOrFail($id);

        $validated = $request->validate([
            'comment' => 'string',
            'rating' => 'numeric|min:0|max:5',
        ]);

        $rating->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Rating updated successfully',
            'data' => $rating
        ]);
    }

    /**
     * Soft delete a rating
     */
    public function destroy($id)
    {
        $rating = ratingCoffeeShop::findOrFail($id);
        $rating->update(['show' => false]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rating deleted successfully'
        ]);
    }
} 