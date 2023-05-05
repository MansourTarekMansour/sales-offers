<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Retrieve all categories
            $categories = Category::all();
            // Return a JSON response with categories as data
            return response()->json([
                'status' => 'success',
                'message' => 'Categories retrieved successfully',
                'data' => CategoryResource::collection($categories)
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
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {

        try {

            // Store image
            $image = $request->file('image')->store('public/category_images');
            // Create a new category 
            $category =  Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $image
            ]);
            // Save the category
            $category->save();
            // Return a JSON response with the newly created category as data
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'data' => new CategoryResource($category)
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
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            // Find the category with the specified ID
            $category = Category::findOrFail($id);
            // Set the name and description of the category
            $category->name = $request->name;
            $category->description = $request->description;

            // Check if a new image was uploaded
            if ($request->hasFile('image')) {
                // Delete the old image
                Storage::delete(str_replace('/storage', 'public', $category->image));
                // Store the new image
                $path = $request->file('image')->store('public/categories');
                $category->image = Storage::url($path);
            }

            // Save the category
            $category->save();
            // Return a JSON response with the updated category as data
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully',
                'data' => new CategoryResource($category)
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
     * Delete the specified resource in storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Find the category with the specified ID
            $category = Category::findOrFail($id);

            // Delete the category image
            if ($category->image) {
                Storage::delete(str_replace('/storage', 'public', $category->image));
            }

            // Delete the category
            $category->delete();
            // Return a JSON response with a success message
            return response()->json([
                'status' => 'success',
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception is caught
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAllCategoryImages()
    {
        Storage::deleteDirectory('public/category_images');

        return response()->json([
            'status' => 'success',
            'message' => 'All category images deleted successfully',
        ]);
    }
}
