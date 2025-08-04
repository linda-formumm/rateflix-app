<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');

// Keep JSON route for debugging
Route::get('/json', function () {
    return response()->json([
        'status' => 'Laravel is running!',
        'php_version' => phpversion(),
        'laravel_version' => app()->version(),
        'environment' => app()->environment(),
        'app_key_set' => !empty(config('app.key')),
        'database_connection' => 'testing...'
    ]);
})->name('json');

// Asset debugging route
Route::get('/assets', function () {
    $buildPath = public_path('build');
    $manifestPath = public_path('build/manifest.json');
    
    return response()->json([
        'build_directory_exists' => is_dir($buildPath),
        'manifest_exists' => file_exists($manifestPath),
        'build_contents' => is_dir($buildPath) ? array_slice(scandir($buildPath), 2) : 'No build directory',
        'manifest_content' => file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : 'No manifest',
        'app_url' => config('app.url'),
        'asset_url' => config('app.asset_url'),
        'vite_manifest' => app('vite')->manifestHash ?? 'No Vite manifest hash'
    ]);
})->name('assets');

// Simple HTML test route
Route::get('/simple', function () {
    return '<!DOCTYPE html><html><head><title>Simple Test</title></head><body><h1>Laravel läuft!</h1><p>PHP Version: ' . phpversion() . '</p></body></html>';
})->name('simple');

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
