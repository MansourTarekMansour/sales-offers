<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Routes for CategoryController
Route::group(['prefix' => 'categories'], function () {
    // Get all categories
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');

    // Create a category
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');

    // Update a category
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');

    // Delete a category
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
