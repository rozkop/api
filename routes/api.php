<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserProfileController;
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
    Route::put('post/{post}/edit', [PostController::class, 'update']);
    Route::delete('post/{post}/delete', [PostController::class, 'destroy']);
    Route::put('/post/{post}/upvote', [PostController::class, 'upVote']);
    Route::put('/post/{post}/downvote', [PostController::class, 'downVote']);
    Route::put('/post/{post}/removevote', [PostController::class, 'removeVote']);

    // Comment actions
    Route::post('post/{post}/comments/submit', [CommentController::class, 'store']);
    Route::delete('post/{post}/comments/{comment}/delete', [CommentController::class, 'destroy']);
    Route::put('/post/{post}/comments/{comment}/upvote', [CommentController::class, 'upVote']);
    Route::put('/post/{post}/comments/{comment}/downvote', [CommentController::class, 'downVote']);
    Route::put('/post/{post}/comments/{comment}/removelike', [CommentController::class, 'removeLike']);
    Route::put('/post/{post}/comments/{comment}/removedislike', [CommentController::class, 'removeDislike']);

    //Community actions
    Route::put('/c/{community}/add', [CommunityController::class, 'addFavourite']);
    Route::put('/c/{community}/remove', [CommunityController::class, 'removeFavorite']);
    Route::post('/c/create', [CommunityController::class, 'store']);
    Route::put('/c/{community}/edit', [CommunityController::class, 'update']);
    Route::delete('/c/{community}/delete', [CommunityController::class, 'destroy']);

    //User actions
    Route::put('/user/update', [UserProfileController::class, 'update']);
    Route::group(['middleware' => ['role:admin']], function() {
        Route::put('user/{user}/givemod', [UserProfileController::class, 'giveModerator']);
        Route::put('user/{user}/removemod', [UserProfileController::class, 'removeModerator']);
        Route::delete('user/{user}/delete', [UserProfileController::class, 'destroy']);
    });

});
