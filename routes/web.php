<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;

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

Route::middleware('auth')->group(function () {
    Route::get  ('/chats',              [ChatsController::class, 'chatapp'])->name('chat');
    Route::post ('/chat/mark-as-read/', [ChatsController::class, 'markAsRead']);
    Route::post ('/messages/{message}', [ChatsController::class, 'setRead']);
    Route::post ('/contacts',           [ChatsController::class, 'contacts']);
    Route::get  ('/conversation/{id}',  [ChatsController::class, 'getMessagesWithContact']);
    Route::post ('/conversation/send',  [ChatsController::class, 'send']);
});

Route::prefix('auth')->group(function(){
    Route::get('/google',           [GoogleController::class, 'redirectToGoogle']);
    Route::get('/google/callback',  [GoogleController::class, 'handleGoogleCallback']);
    Route::get('/facebook',         [FacebookController::class, 'redirectToFacebook']);
    Route::get('/facebook/callback',[FacebookController::class, 'handleFacebookCallback']);
});

Route::prefix('admin')->group(function() {
    Route::get('/',                 [AdminController::class, 'index'])->name('admin.index');
    Route::patch ('/photo/{user}',  [AdminController::class, 'approvePhoto']);
    Route::delete('/photo/{user}',  [AdminController::class, 'deletePhoto']);
});

Route::prefix('profile')->group(function(){
    Route::get('/',           [ProfilesController::class, 'index'])->name('profile.index');
    Route::get('/edit',       [ProfilesController::class, 'edit']) ->name('profile.edit');
    Route::get('/{userId}',   [ProfilesController::class, 'show']) ->name('profile.show');
});

Route::prefix('photo')->group(function(){
    Route::post  ('/',      [ImageController::class, 'store']) ->name('image.store');
    Route::delete('/',      [ImageController::class, 'delete'])->name('image.delete');
});

