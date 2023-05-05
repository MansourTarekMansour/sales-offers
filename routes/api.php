<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MarketController;

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
    Route::post('/create', [CategoryController::class, 'store'])->name('categories.store');
    // Update a category
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    // Delete a category
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // Delete all category images
    Route::delete('/delete/all/category_images', [CategoryController::class, 'deleteAllCategoryImages']);
});


Route::group(['prefix' => 'markets'], function () {
    // Get all markets
    Route::get('/', [MarketController::class, 'index'])->name('markets.index');
    // Get specific category markets
    Route::get('/category/{id}', [MarketController::class, 'getCategoryMarkets'])->name('markets.getCategoryMarkets');
    // Create a market
    Route::post('/create', [MarketController::class, 'store'])->name('markets.store');
    // Update a market
    Route::put('/update/{id}', [MarketController::class, 'update'])->name('markets.update');
    // Delete a market
    Route::delete('/delete/{id}', [MarketController::class, 'destroy'])->name('markets.destroy');
    // Delete all market Logos
    Route::delete('/delete/all/market_logos', [MarketController::class, 'deleteAllMarketLogos']);
});



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
