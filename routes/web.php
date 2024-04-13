<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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




Auth::routes();



// category routes for backend

// Route::get('admin/categories', [CategoryController::class, 'index'])->middleware('auth')->name('categories.index');
// Route::post('admin/categories', [CategoryController::class, 'store'])->middleware('auth')->name('categories.store');
// Route::get('admin/categories/create', [CategoryController::class, 'create'])->middleware('auth')->name('categories.create');
// Route::get('admin/categories/{category}', [CategoryController::class, 'show'])->middleware('auth')->name('categories.show');
// Route::patch('admin/categories/{category}', [CategoryController::class, 'update'])->middleware('auth')->name('categories.update');
// Route::delete('admin/categories/{category}', [CategoryController::class, 'destroy'])->middleware('auth')->name('categories.destroy');
// Route::get('admin/categories/{category}/edit', [CategoryController::class, 'edit'])->middleware('auth')->name('categories.edit');

Route::middleware('auth')->prefix('admin')->group(function () {
//   Route::group(['middleware' => 'admin'],function () {
//     Route::resource('categories', CategoryController::class);
//     Route::resource('posts',PostController::class);
//     Route::resource('tags',TagsController::class);
//     Route::resource('authors',AuthorController::class);
//     });
});
Route::group(['middleware' => 'admin'],function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('posts',PostController::class);
    Route::resource('tags',TagsController::class);
    Route::resource('authors',AuthorController::class);
    });
