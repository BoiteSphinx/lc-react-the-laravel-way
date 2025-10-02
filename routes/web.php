<?php

use App\Http\Controllers\Puppy\{DeleteController, IndexController, LikeController, StoreController};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', IndexController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('puppies', StoreController::class)
        ->name('puppies.store');
    Route::patch('puppies/{puppy}/liked', LikeController::class)
        ->name('puppies.like');
    Route::delete('puppies/{puppy}', DeleteController::class)
        ->name('puppies.delete');

    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
