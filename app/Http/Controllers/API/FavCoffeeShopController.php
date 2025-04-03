<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\favCoffeeShop;
use Illuminate\Http\Request;

class FavCoffeeShopController extends Controller
{
    /**
     * Get all favorite coffee shops for a user
     */
    public function getByUser($userId)
    {
        $favCoffeeShops = favCoffeeShop::with('coffeeShop')
            ->where('user_id', $userId)
            ->where('is_favorite', true)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $favCoffeeShops
        ]);
    }

    /**
     * Create a new favorite coffee shop
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'coffee_shop_id' => 'required|exists:coffee_shops,id',
        ]);

        $existing = favCoffeeShop::where('user_id', $validated['user_id'])
            ->where('coffee_shop_id', $validated['coffee_shop_id'])
            ->first();

        if ($existing) {
            $existing->update(['is_favorite' => true]);
            $favCoffeeShop = $existing;
        } else {
            $favCoffeeShop = favCoffeeShop::create($validated);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Coffee shop added to favorites successfully',
            'data' => $favCoffeeShop
        ], 201);
    }

    /**
     * Update favorite status
     */
    public function update(Request $request, $userId, $coffeeShopId)
    {
        $validated = $request->validate([
            'is_favorite' => 'required|boolean'
        ]);

        $favCoffeeShop = favCoffeeShop::where('user_id', $userId)
            ->where('coffee_shop_id', $coffeeShopId)
            ->firstOrFail();

        $favCoffeeShop->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Favorite status updated successfully',
            'data' => $favCoffeeShop
        ]);
    }
} 