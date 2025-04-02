<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\coffeeShop;
use Illuminate\Http\Request;

class CoffeeShopController extends Controller
{
    /**
     * Get all active coffee shops
     */
    public function index()
    {
        $coffeeShops = coffeeShop::where('show', true)->get();
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
            'address' => 'string',
            'phone' => 'string',
            'email' => 'email',
            'website' => 'url',
            'thumbnail' => 'string',
            'description' => 'string',
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
        $coffeeShop = coffeeShop::where('show', true)->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => $coffeeShop
        ]);
    }
}