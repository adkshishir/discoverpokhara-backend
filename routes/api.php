<?php

use App\Http\Controllers\Api\MenuController;
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
Route::get('/tags',[\App\Http\Controllers\Api\TagController::class,'index']);
Route::get('/tags/{id}',[\App\Http\Controllers\Api\TagController::class,'show']);
Route::get('/categories',[\App\Http\Controllers\Api\CategoryController::class,'index']);
Route::get('/categories/{id}',[\App\Http\Controllers\Api\CategoryController::class,'show']);
Route::get('/posts/{id}',[\App\Http\Controllers\Api\PostController::class,'show']);
Route::get('/home',[MenuController::class,'index']);
// Route::get('/posts',[\App\Http\Controllers\Api\PostController::class,'index']);
