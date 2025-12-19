<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\KingController;
use App\Http\Controllers\KingdomController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HistoricalSiteController;
use App\Http\Controllers\PersonalityController;
use App\Http\Controllers\LanguageItemController;
use App\Http\Controllers\OralHistoryController;
use App\Http\Controllers\DiasporaStoryController;
use App\Http\Controllers\HistoricalEventController;

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

// Ijebu Heritage Museum routes
Route::get('/festivals', [FestivalController::class, 'index'])->name('festivals.index');
Route::get('/festivals/{festival}', [FestivalController::class, 'show'])->name('festivals.show');
Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/{food}', [FoodController::class, 'show'])->name('foods.show');
Route::get('/sites', [HistoricalSiteController::class, 'index'])->name('sites.index');
Route::get('/sites/{site}', [HistoricalSiteController::class, 'show'])->name('sites.show');
Route::get('/personalities', [PersonalityController::class, 'index'])->name('personalities.index');
Route::get('/personalities/{personality}', [PersonalityController::class, 'show'])->name('personalities.show');
Route::get('/language', [LanguageItemController::class, 'index'])->name('language.items.index');
Route::get('/language/{languageItem}', [LanguageItemController::class, 'show'])->name('language.items.show');
Route::get('/oral-histories', [OralHistoryController::class, 'index'])->name('oral.histories.index');
Route::get('/oral-histories/{oralHistory}', [OralHistoryController::class, 'show'])->name('oral.histories.show');
Route::get('/diaspora', [DiasporaStoryController::class, 'index'])->name('diaspora.stories.index');
Route::get('/diaspora/{diasporaStory}', [DiasporaStoryController::class, 'show'])->name('diaspora.stories.show');
Route::get('/historical-events', [HistoricalEventController::class, 'index'])->name('historical.events.index');
Route::get('/historical-events/{event}', [HistoricalEventController::class, 'show'])->name('historical.events.show');

// ... traditions, contact

// Public routes for Ijebu Heritage Museum
Route::get('/photo-archives', [App\Http\Controllers\PublicController::class, 'photoArchives'])->name('public.photo.archives');
Route::get('/oral-histories', [App\Http\Controllers\PublicController::class, 'oralHistories'])->name('public.oral.histories');
Route::get('/olu-corner', [App\Http\Controllers\PublicController::class, 'oluCorner'])->name('public.olu.corner');

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

    // Ijebu Heritage Museum Admin Routes
    Route::resource('festivals', App\Http\Controllers\Admin\FestivalController::class)->names([
        'index' => 'admin.festivals.index',
        'create' => 'admin.festivals.create',
        'store' => 'admin.festivals.store',
        'show' => 'admin.festivals.show',
        'edit' => 'admin.festivals.edit',
        'update' => 'admin.festivals.update',
        'destroy' => 'admin.festivals.destroy',
    ]);
    Route::resource('foods', App\Http\Controllers\Admin\FoodController::class)->names([
        'index' => 'admin.foods.index',
        'create' => 'admin.foods.create',
        'store' => 'admin.foods.store',
        'show' => 'admin.foods.show',
        'edit' => 'admin.foods.edit',
        'update' => 'admin.foods.update',
        'destroy' => 'admin.foods.destroy',
    ]);
    Route::resource('sites', App\Http\Controllers\Admin\HistoricalSiteController::class)->names([
        'index' => 'admin.sites.index',
        'create' => 'admin.sites.create',
        'store' => 'admin.sites.store',
        'show' => 'admin.sites.show',
        'edit' => 'admin.sites.edit',
        'update' => 'admin.sites.update',
        'destroy' => 'admin.sites.destroy',
    ]);
    Route::resource('personalities', App\Http\Controllers\Admin\PersonalityController::class)->names([
        'index' => 'admin.personalities.index',
        'create' => 'admin.personalities.create',
        'store' => 'admin.personalities.store',
        'show' => 'admin.personalities.show',
        'edit' => 'admin.personalities.edit',
        'update' => 'admin.personalities.update',
        'destroy' => 'admin.personalities.destroy',
    ]);
    Route::resource('language/items', App\Http\Controllers\Admin\LanguageItemController::class)->names([
        'index' => 'admin.language.items.index',
        'create' => 'admin.language.items.create',
        'store' => 'admin.language.items.store',
        'show' => 'admin.language.items.show',
        'edit' => 'admin.language.items.edit',
        'update' => 'admin.language.items.update',
        'destroy' => 'admin.language.items.destroy',
    ]);
    Route::resource('oral/histories', App\Http\Controllers\Admin\OralHistoryController::class)->names([
        'index' => 'admin.oral.histories.index',
        'create' => 'admin.oral.histories.create',
        'store' => 'admin.oral.histories.store',
        'show' => 'admin.oral.histories.show',
        'edit' => 'admin.oral.histories.edit',
        'update' => 'admin.oral.histories.update',
        'destroy' => 'admin.oral.histories.destroy',
    ]);
    Route::resource('diaspora/stories', App\Http\Controllers\Admin\DiasporaStoryController::class)->names([
        'index' => 'admin.diaspora.stories.index',
        'create' => 'admin.diaspora.stories.create',
        'store' => 'admin.diaspora.stories.store',
        'show' => 'admin.diaspora.stories.show',
        'edit' => 'admin.diaspora.stories.edit',
        'update' => 'admin.diaspora.stories.update',
        'destroy' => 'admin.diaspora.stories.destroy',
    ]);
    Route::resource('historical/events', App\Http\Controllers\Admin\HistoricalEventController::class)->names([
        'index' => 'admin.historical.events.index',
        'create' => 'admin.historical.events.create',
        'store' => 'admin.historical.events.store',
        'show' => 'admin.historical.events.show',
        'edit' => 'admin.historical.events.edit',
        'update' => 'admin.historical.events.update',
        'destroy' => 'admin.historical.events.destroy',
    ]);

    // Photo Archive
    Route::resource('photo/archives', App\Http\Controllers\Admin\PhotoArchiveController::class)->names([
        'index' => 'admin.photo.archives.index',
        'create' => 'admin.photo.archives.create',
        'store' => 'admin.photo.archives.store',
        'show' => 'admin.photo.archives.show',
        'edit' => 'admin.photo.archives.edit',
        'update' => 'admin.photo.archives.update',
        'destroy' => 'admin.photo.archives.destroy',
    ]);

    // Oral History Archive
    Route::resource('oral/history/archives', App\Http\Controllers\Admin\OralHistoryArchiveController::class)->names([
        'index' => 'admin.oral.history.archives.index',
        'create' => 'admin.oral.history.archives.create',
        'store' => 'admin.oral.history.archives.store',
        'show' => 'admin.oral.history.archives.show',
        'edit' => 'admin.oral.history.archives.edit',
        'update' => 'admin.oral.history.archives.update',
        'destroy' => 'admin.oral.history.archives.destroy',
    ]);

    // Olu's Corner
    Route::resource('olu/corner', App\Http\Controllers\Admin\OluCornerController::class)->names([
        'index' => 'admin.olu.corner.index',
        'create' => 'admin.olu.corner.create',
        'store' => 'admin.olu.corner.store',
        'show' => 'admin.olu.corner.show',
        'edit' => 'admin.olu.corner.edit',
        'update' => 'admin.olu.corner.update',
        'destroy' => 'admin.olu.corner.destroy',
    ]);

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
