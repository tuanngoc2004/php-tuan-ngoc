<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('pos', 'App\Http\Controllers\PostController');

Route::apiResource('categories', CategoryController::class);

Route::apiResource('products', ProductController::class);


Route::apiResource('posts', PostController::class);



Route::get('/products', [ProductController::class, 'index']);

// Creating a new product
Route::post('/products', [ProductController::class, 'store']);

// Fetching a single product for editing
Route::get('/products/{id}/edit', [ProductController::class, 'edit']);

// Updating an existing product
Route::put('/products/{id}', [ProductController::class, 'update']);

// Deleting a product
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Fetching categories
Route::get('/categories', [CategoryController::class, 'index']);
