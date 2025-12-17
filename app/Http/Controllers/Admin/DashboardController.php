<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\King;
use App\Models\Event;
use App\Models\Artifact;
use App\Models\Booking;
use App\Models\PublishingQueue;

class DashboardController extends BaseController
{
    public function index()
    {
        $featuredKingsCount = King::where('featured', true)->count();
        $eventsCount = Event::count();
        $artifactsCount = Artifact::count();
        $bookingsCount = Booking::count();

        $recentBookings = Booking::with('user', 'ticket')
            ->latest()
            ->take(5)
            ->get();

        $publishingQueueCount = PublishingQueue::count();
        $draftQueueItems = PublishingQueue::where('status', 'draft')->count();
        $readyQueueItems = PublishingQueue::where('status', 'ready')->count();

        $recentQueueItems = PublishingQueue::with('user')
            ->latest()
            ->take(5)
            ->get();

        return $this->render('Admin/Dashboard', [
            'featuredKingsCount' => $featuredKingsCount,
            'eventsCount' => $eventsCount,
            'artifactsCount' => $artifactsCount,
            'bookingsCount' => $bookingsCount,
            'recentBookings' => $recentBookings,
            'publishingQueueCount' => $publishingQueueCount,
            'draftQueueItems' => $draftQueueItems,
            'readyQueueItems' => $readyQueueItems,
            'recentQueueItems' => $recentQueueItems
        ]);
    }
}
