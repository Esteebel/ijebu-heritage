<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\KingController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ArtifactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public (Inertia pages)
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/kings', [KingController::class, 'index'])->name('kings.index');
Route::get('/kings/{king}', [KingController::class, 'show'])->name('kings.show');
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/exhibits', [ArtifactController::class, 'index'])->name('exhibits.index');
Route::get('/exhibits/{artifact}', [ArtifactController::class, 'show'])->name('exhibits.show');

// Gallery route pointing to exhibits
Route::get('/gallery', [ArtifactController::class, 'index'])->name('gallery.index');

// ... traditions, contact

// Admin (auth + middleware)
Route::middleware(['auth', 'admin.editor'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('kings', App\Http\Controllers\Admin\KingController::class);
    Route::resource('media', App\Http\Controllers\Admin\MediaController::class);
    Route::resource('events', App\Http\Controllers\Admin\EventController::class);
    Route::resource('ads', App\Http\Controllers\Admin\AdController::class);
    Route::post('media/bulk-upload', [App\Http\Controllers\Admin\MediaController::class, 'bulkUpload']);
    // ... other admin routes
});

// Admin-only routes (not accessible by editors)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Routes that only admins can access
});
