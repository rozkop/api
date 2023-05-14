<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Middleware\OptionalAuthSanctum;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login/{provider}', [SocialiteController::class, 'redirect']);
Route::get('/login/{provider}/callback', [SocialiteController::class, 'callback']);

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');


// Public routes
Route::get('/c', [CommunityController::class, 'index']);
Route::group(['middleware' => [OptionalAuthSanctum::class]], function () {
    Route::get('/{sortField?}', [PostController::class, 'showPosts']);
    Route::get('/post/{post}', [PostController::class, 'show']);
    Route::get('/c/{community:slug}/{sortField?}', [CommunityController::class, 'show']);
});
// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Auth route
    Route::post('/logout', [AuthController::class, 'logout']);

    // Post actions
    Route::post('/c/{community:slug}/post/submit', [PostController::class, 'store']);
    Route::put('/post/{post}/edit', [PostController::class, 'update']);
    Route::delete('/post/{post}/delete', [PostController::class, 'destroy']);
    Route::put('/post/{post}/react/{reaction?}', [PostController::class, 'react']);
    Route::put('/post/{post}/report', [PostController::class, 'report']);

    // Comment actions
    Route::post('/post/{post}/comments/submit', [CommentController::class, 'store']);
    Route::delete('/post/{post}/comments/{comment}/delete', [CommentController::class, 'destroy']);
    Route::put('/post/{post}/comments/{comment}/react/{reaction?}', [CommentController::class, 'react']);

    //Community actions
    Route::put('/c/{community:slug}/react', [CommunityController::class, 'react']);
    Route::post('/c/create', [CommunityController::class, 'store']);
    Route::put('/c/{community:slug}/edit', [CommunityController::class, 'update']);
    Route::delete('/c/{community:slug}/delete', [CommunityController::class, 'destroy']);

    //User actions
    Route::put('/user/update', [UserProfileController::class, 'update']);
    Route::get('/user/show', [UserProfileController::class, 'show']);
    Route::group(['middleware' => ['role:admin']], function () {
        Route::put('user/{user}/givemod', [UserProfileController::class, 'giveModerator']);
        Route::put('user/{user}/removemod', [UserProfileController::class, 'removeModerator']);
        Route::delete('user/{user}/delete', [UserProfileController::class, 'destroy']);
        Route::get('/post/admin/trashed', [PostController::class, 'showTrashed']);
        Route::get('user/admin/list', [UserProfileController::class, 'getList']);
        Route::get('post/admin/reported', [PostController::class, 'showReported']);
    });

});
