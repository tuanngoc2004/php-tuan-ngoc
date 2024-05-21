<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view("/{any}", "app")->where("any", ".*");


Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::put('tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');


// Route::resource('categories', CategoryController::class)->middleware('custom');
// Route::middleware('custom')->group(function () {
//     Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
//     Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
//     Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
//     Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
//     Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
//     Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
// });

Route::resource('categories', CategoryController::class)->middleware('custom');

// Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
// Route::put('/categories/{id}', [CategoryController::class, 'update']);
// Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
// Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);

Route::resource('products', ProductController::class);

Route::post('/products', [ProductController::class, 'store'])->name('products.store');