<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/blogs', [BlogController::class, 'showBlogs']);
Route::post('/blogs', [BlogController::class, 'createBlog']) ->middleware('auth:sanctum');
Route::delete('/blogs', [BlogController::class, 'deleteBlog']) ->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);