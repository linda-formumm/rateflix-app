<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

// Test route for debugging
Route::get('/test', function () {
    return view('test');
})->name('test');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('movies', 'movies')
    ->middleware(['auth', 'verified'])
    ->name('movies');

Route::view('ratings', 'ratings')
    ->middleware(['auth', 'verified'])
    ->name('ratings');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
