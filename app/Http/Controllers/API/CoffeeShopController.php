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
            'pictures.*' => 'string'
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
            'name' => 'string|max:255',
            'houseNumber' => 'string',
            'street' => 'nullable|string',
            'ward' => 'string',
            'district' => 'string',
            'city' => 'string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'thumbnail' => 'string',
            'description' => 'string',
            'pictures' => 'nullable|array',
            'pictures.*' => 'string'
        ]);

        $coffeeShop->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Coffee shop updated successfully',
            'data' => $coffeeShop
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