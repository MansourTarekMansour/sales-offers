<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MarketRequest;
use App\Http\Resources\MarketResource;
use Illuminate\Support\Facades\Storage;

class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Retrieve all markets
            $markets = Market::all();
            // Return a JSON response with markets as data
            return response()->json([
                'status' => 'success',
                'message' => 'Markets retrieved successfully',
                'data' => MarketResource::collection($markets)
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception is caught
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
 * Display a listing of the resource.
 *
 * @param int $categoryId
 * @return \Illuminate\Http\JsonResponse
 */
public function getCategoryMarkets($categoryId)
{
    try {
        // Retrieve all markets for the given category ID
        $markets = Market::where('category_id', $categoryId)->get();
        // Return a JSON response with markets as data
        $data = $markets->map(function ($market) {
            return (new MarketResource($market))->toArray($market, false);
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Markets retrieved successfully',
            'data' => $data
        ]);
    } catch (\Exception $e) {
        // Return an error response if an exception is caught
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}



    public function store(MarketRequest $request)
    {
        try {
            // Store image
            $image = $request->file('logo')->store('public/market_logos');
            // Create a new market 
            $market =  Market::create([
                'name' => $request->name,
                'description' => $request->description,
                'logo' => $image,
                'category_id' => $request->category_id // Set the category_id field to the ID of the category
            ]);
            // Save the market
            $market->save();
            // Return a JSON response with the newly created market as data
            return response()->json([
                'status' => 'success',
                'message' => 'Market created successfully',
                'data' => new MarketResource($market)
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception is caught
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\MarketRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MarketRequest $request, $id)
    {
        try {
            // Find the market with the specified ID
            $market = Market::findOrFail($id);

            // Set the name, description, and category_id of the market
            $market->name = $request->name;
            $market->description = $request->description;
            $market->category_id = $request->category_id;

            // Check if a new logo was uploaded
            if ($request->hasFile('logo')) {
                // Delete the old logo
                Storage::delete(str_replace('/storage', 'public', $market->logo));
                // Store the new logo
                $path = $request->file('logo')->store('public/market_logos');
                $market->logo = Storage::url($path);
            }

            // Save the market
            $market->save();
            // Return a JSON response with the updated market as data
            return response()->json([
                'status' => 'success',
                'message' => 'Market updated successfully',
                'data' => new MarketResource($market)
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception is caught
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Find the market with the specified ID
            $market = Market::findOrFail($id);
            // Delete the market's logo
            Storage::delete(str_replace('/storage', 'public', $market->logo));
            // Delete the market
            $market->delete();
            // Return a JSON response indicating success
            return response()->json([
                'status' => 'success',
                'message' => 'Market deleted successfully'
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception is caught
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
