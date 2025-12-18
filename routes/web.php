<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\KingController;
use App\Http\Controllers\KingdomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TourController;

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

// Test route for debugging
Route::get('/test-kings', function () {
    $kings = \App\Models\King::with('portraitMedia')->get();
    return response()->json($kings);
});

// Authentication Routes...
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Public (Inertia pages)
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/kings', [KingController::class, 'index'])->name('kings.index');
Route::get('/kings/{king}', [KingController::class, 'show'])->name('kings.show');
Route::get('/kingdoms', [KingdomController::class, 'index'])->name('kingdoms.index');
Route::get('/kingdoms/{kingdom}', [KingdomController::class, 'show'])->name('kingdoms.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/exhibits', [ArtifactController::class, 'index'])->name('exhibits.index');
Route::get('/exhibits/{artifact}', [ArtifactController::class, 'show'])->name('exhibits.show');
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/virtual-tour', [TourController::class, 'index'])->name('tour.index');

// Gallery route pointing to exhibits
Route::get('/gallery', [ArtifactController::class, 'index'])->name('gallery.index');

// ... traditions, contact

// Admin (auth + middleware)
Route::middleware(['auth', 'admin.editor'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('kings', App\Http\Controllers\Admin\KingController::class)->names([
        'index' => 'admin.kings.index',
        'create' => 'admin.kings.create',
        'store' => 'admin.kings.store',
        'show' => 'admin.kings.show',
        'edit' => 'admin.kings.edit',
        'update' => 'admin.kings.update',
        'destroy' => 'admin.kings.destroy',
    ]);
    Route::resource('media', App\Http\Controllers\Admin\MediaController::class)->names([
        'index' => 'admin.media.index',
        'create' => 'admin.media.create',
        'store' => 'admin.media.store',
        'show' => 'admin.media.show',
        'edit' => 'admin.media.edit',
        'update' => 'admin.media.update',
        'destroy' => 'admin.media.destroy',
    ]);
    Route::resource('events', App\Http\Controllers\Admin\EventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'show' => 'admin.events.show',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);
    Route::resource('ads', App\Http\Controllers\Admin\AdController::class)->names([
        'index' => 'admin.ads.index',
        'create' => 'admin.ads.create',
        'store' => 'admin.ads.store',
        'show' => 'admin.ads.show',
        'edit' => 'admin.ads.edit',
        'update' => 'admin.ads.update',
        'destroy' => 'admin.ads.destroy',
    ]);
    Route::resource('artifacts', App\Http\Controllers\Admin\ArtifactController::class)->names([
        'index' => 'admin.artifacts.index',
        'create' => 'admin.artifacts.create',
        'store' => 'admin.artifacts.store',
        'show' => 'admin.artifacts.show',
        'edit' => 'admin.artifacts.edit',
        'update' => 'admin.artifacts.update',
        'destroy' => 'admin.artifacts.destroy',
    ]);
    Route::resource('dynasties', App\Http\Controllers\Admin\DynastyController::class)->names([
        'index' => 'admin.dynasties.index',
        'create' => 'admin.dynasties.create',
        'store' => 'admin.dynasties.store',
        'show' => 'admin.dynasties.show',
        'edit' => 'admin.dynasties.edit',
        'update' => 'admin.dynasties.update',
        'destroy' => 'admin.dynasties.destroy',
    ]);
    Route::get('kingdoms', [App\Http\Controllers\KingdomController::class, 'adminIndex'])->name('admin.kingdoms.index');
    Route::get('kingdoms/{kingdom}', [App\Http\Controllers\KingdomController::class, 'adminShow'])->name('admin.kingdoms.show');
    Route::resource('tickets', App\Http\Controllers\Admin\TicketController::class)->names([
        'index' => 'admin.tickets.index',
        'create' => 'admin.tickets.create',
        'store' => 'admin.tickets.store',
        'show' => 'admin.tickets.show',
        'edit' => 'admin.tickets.edit',
        'update' => 'admin.tickets.update',
        'destroy' => 'admin.tickets.destroy',
    ]);
    Route::resource('tours', App\Http\Controllers\Admin\TourController::class)->names([
        'index' => 'admin.tours.index',
        'create' => 'admin.tours.create',
        'store' => 'admin.tours.store',
        'show' => 'admin.tours.show',
        'edit' => 'admin.tours.edit',
        'update' => 'admin.tours.update',
        'destroy' => 'admin.tours.destroy',
    ]);
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class)->names([
        'index' => 'admin.bookings.index',
        'create' => 'admin.bookings.create',
        'store' => 'admin.bookings.store',
        'show' => 'admin.bookings.show',
        'edit' => 'admin.bookings.edit',
        'update' => 'admin.bookings.update',
        'destroy' => 'admin.bookings.destroy',
    ]);
    Route::resource('publishing/queue', App\Http\Controllers\Admin\PublishingQueueController::class)->names([
        'index' => 'admin.publishing.queue.index',
        'create' => 'admin.publishing.queue.create',
        'store' => 'admin.publishing.queue.store',
        'show' => 'admin.publishing.queue.show',
        'edit' => 'admin.publishing.queue.edit',
        'update' => 'admin.publishing.queue.update',
        'destroy' => 'admin.publishing.queue.destroy',
    ]);
    Route::post('publishing/queue/{publishingQueue}/publish', [App\Http\Controllers\Admin\PublishingQueueController::class, 'publish'])->name('admin.publishing.queue.publish');
    Route::post('media/bulk-upload', [App\Http\Controllers\Admin\MediaController::class, 'bulkUpload']);

    // Settings route
    Route::get('/settings', function () {
        return inertia('Admin/Settings/Index');
    })->name('settings.index');


});

// Admin-only routes (not accessible by editors)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});
