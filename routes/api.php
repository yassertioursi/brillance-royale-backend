<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoriesController, ProductsController};



Route::middleware('api')->prefix('v1')->group(function () {
    Route::get('categories', [CategoriesController::class, 'index']);

});

Route::middleware('api')->prefix('v1')->group(function () {
    Route::get('products', [ProductsController::class, 'all']); 
    Route::get('products/promo', [ProductsController::class, 'getPromoProducts']);
    Route::get('products/latest', [ProductsController::class, 'latest']);

});
