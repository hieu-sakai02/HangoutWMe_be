<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\coffeeShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoffeeShopController extends Controller
{
    /**
     * Get all active coffee shops
     */
    public function index()
    {
        $coffeeShops = coffeeShop::where('show', true)
            ->withAvg(['ratings' => function($query) {
                $query->where('show', true);
            }], 'rating')
            ->get()
            ->map(function($shop) {
                $shop->rating = $shop->ratings_avg_rating ?? 0;
                return $shop;
            });

        return response()->json([
            'status' => 'success',
            'data' => $coffeeShops
        ]);
    }

    /**
     * Create a new coffee shop
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'houseNumber' => 'required|string',
            'street' => 'nullable|string',
            'ward' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'thumbnail' => 'required|string',
            'description' => 'required|string',
            'pictures' => 'nullable|array',
            'pictures.*' => 'string',
            'carPark' => 'nullable|boolean',
            'petFriendly' => 'nullable|boolean',
            'wifi' => 'nullable|string',
            'cake' => 'nullable|boolean',
            'outdoorSeating' => 'nullable|boolean',
            'indoorSeating' => 'nullable|boolean',
            'openTime' => 'nullable|date_format:H:i',
            'closeTime' => 'nullable|date_format:H:i',
            'overNight' => 'nullable|boolean'
        ]);

        $validated['show'] = true; 

        $coffeeShop = coffeeShop::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Coffee shop created successfully',
            'data' => $coffeeShop
        ], 201);
    }

    /**
     * Update a coffee shop
     */
    public function update(Request $request, $id)
    {
        $coffeeShop = coffeeShop::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'houseNumber' => 'sometimes|string',
            'street' => 'sometimes|nullable|string',
            'ward' => 'sometimes|string',
            'district' => 'sometimes|string',
            'city' => 'sometimes|string',
            'phone' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email',
            'website' => 'sometimes|nullable|url',
            'thumbnail' => 'sometimes|string',
            'description' => 'sometimes|string',
            'pictures' => 'sometimes|nullable|array',
            'pictures.*' => 'string',
            'carPark' => 'sometimes|nullable|boolean',
            'petFriendly' => 'sometimes|nullable|boolean',
            'wifi' => 'sometimes|nullable|string',
            'cake' => 'sometimes|nullable|boolean',
            'outdoorSeating' => 'sometimes|nullable|boolean',
            'indoorSeating' => 'sometimes|nullable|boolean',
            'openTime' => 'sometimes|nullable|date_format:H:i',
            'closeTime' => 'sometimes|nullable|date_format:H:i',
            'overNight' => 'sometimes|nullable|boolean'
        ]);

        $coffeeShop->fill($validated);
        $coffeeShop->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Coffee shop updated successfully',
            'data' => $coffeeShop->fresh()
        ]);
    }

    /**
     * Soft delete (hide) a coffee shop
     */
    public function destroy($id)
    {
        $coffeeShop = coffeeShop::findOrFail($id);
        $coffeeShop->update(['show' => false]);

        return response()->json([
            'status' => 'success',
            'message' => 'Coffee shop hidden successfully'
        ]);
    }

    /**
     * Get details of a specific coffee shop
     */
    public function show($id)
    {
        $coffeeShop = coffeeShop::where('show', true)
            ->withAvg(['ratings' => function($query) {
                $query->where('show', true);
            }], 'rating')
            ->findOrFail($id);
        
        $coffeeShop->rating = $coffeeShop->ratings_avg_rating ?? 0;

        return response()->json([
            'status' => 'success',
            'data' => $coffeeShop
        ]);
    }

    /**
     * Get top 10 coffee shops by rating
     */
    public function getTopRated()
    {
        $topCoffeeShops = coffeeShop::where('show', true)
            ->withCount(['ratings as average_rating' => function($query) {
                $query->select(DB::raw('coalesce(avg(rating),0)'))
                    ->where('show', true);
            }])
            ->orderByDesc('average_rating')
            ->limit(10)
            ->get()
            ->map(function($shop) {
                $shop->rating = round($shop->average_rating, 1);
                return $shop;
            });

        return response()->json([
            'status' => 'success',
            'data' => $topCoffeeShops
        ]);
    }
}