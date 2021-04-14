<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\ChatsController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// google auth routes
Route::get('auth/google',           [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback',  [GoogleController::class, 'handleGoogleCallback']);

// facebook authentication routes
Route::get('auth/facebook',         [FacebookController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback',[FacebookController::class, 'handleFacebookCallback']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get  ('/chats',              [ChatsController::class, 'chatapp'])->name('chat');
    Route::post ('/chat/mark-as-read/', [ChatsController::class, 'markAsRead']);
    Route::post ('/messages/{message}', [ChatsController::class, 'setRead']);
    Route::post ('/contacts',           [ChatsController::class, 'contacts']);
    Route::get  ('/conversation/{id}',  [ChatsController::class, 'getMessagesWithContact']);
    Route::post ('/conversation/send',  [ChatsController::class, 'send']);
});