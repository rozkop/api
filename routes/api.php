<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Public routes
Route::get('/', [PostController::class, 'hotSort']);
Route::get('/new', [PostController::class, 'newSort']);
Route::get('/post/{post}/', [PostController::class, 'show']);
Route::get('/c/{community}/', [CommunityController::class, 'show']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Auth route
    Route::post('/logout', [AuthController::class, 'logout']);

    // Post actions
    Route::post('post/submit', [PostController::class, 'store']);
    Route::put('post/edit/{post}', [PostController::class, 'update']);
    Route::delete('post/delete/{post}', [PostController::class, 'destroy']);

    //Community actions
    Route::post('/c/create', [CommunityController::class, 'store']);
    Route::put('/c/edit/{community}', [CommunityController::class, 'update']);
    Route::delete('/c/delete/{community}', [CommunityController::class, 'destroy']);

});
