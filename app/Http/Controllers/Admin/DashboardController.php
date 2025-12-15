<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\King;
use App\Models\Event;
use App\Models\Media;
use App\Models\User;
use App\Models\Artifact;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for various entities
        $kingsCount = King::count();
        $eventsCount = Event::count();
        $mediaCount = Media::count();
        $artifactsCount = Artifact::count();
        $usersCount = User::count();

        // Simulate draft and live content counts
        $liveContentCount = $kingsCount + $eventsCount + $artifactsCount;
        $draftContentCount = rand(5, 15); // Simulated draft content
        $pendingApprovalsCount = rand(3, 8); // Simulated pending approvals
        $totalBookingsCount = rand(20, 50); // Simulated bookings
        $upcomingEventsCount = Event::where('start_datetime', '>=', now())->count();
        $mediaStoragePercentage = rand(30, 85); // Simulated storage percentage

        // Sample activity data
        $activities = [
            [
                'id' => 1,
                'user' => 'Admin User',
                'action' => 'updated',
                'target' => 'Timeline: 1890',
                'time' => '2 hours ago',
                'type' => 'update'
            ],
            [
                'id' => 2,
                'user' => 'Editor John',
                'action' => 'set live',
                'target' => 'Event \'Royal Festival\'',
                'time' => '5 hours ago',
                'type' => 'publish'
            ],
            [
                'id' => 3,
                'user' => 'Admin User',
                'action' => 'approved',
                'target' => 'Booking #12345',
                'time' => '1 day ago',
                'type' => 'booking'
            ],
            [
                'id' => 4,
                'user' => 'Editor Sarah',
                'action' => 'created',
                'target' => 'King Olusegun',
                'time' => '1 day ago',
                'type' => 'update'
            ],
            [
                'id' => 5,
                'user' => 'Admin User',
                'action' => 'uploaded',
                'target' => 'Gallery Images',
                'time' => '2 days ago',
                'type' => 'update'
            ]
        ];

        // Content status data
        $contentStatus = [
            'live' => $liveContentCount,
            'draft' => $draftContentCount,
            'pending' => $pendingApprovalsCount,
            'total' => $liveContentCount + $draftContentCount + $pendingApprovalsCount
        ];

        // Publishing queue sample data
        $publishingQueue = [
            [
                'id' => 1,
                'title' => 'Ancient Artifacts Exhibition',
                'type' => 'Event',
                'author' => 'Editor John',
                'authorId' => 2,
                'status' => 'ready',
                'lastUpdated' => '2 hours ago'
            ],
            [
                'id' => 2,
                'title' => 'Kingdom Timeline Update',
                'type' => 'Timeline',
                'author' => 'Editor Sarah',
                'authorId' => 3,
                'status' => 'draft',
                'lastUpdated' => '1 day ago'
            ],
            [
                'id' => 3,
                'title' => 'Royal Ceremonies Gallery',
                'type' => 'Gallery',
                'author' => 'Admin User',
                'authorId' => 1,
                'status' => 'ready',
                'lastUpdated' => '3 days ago'
            ]
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'liveContent' => $liveContentCount,
                'draftContent' => $draftContentCount,
                'pendingApprovals' => $pendingApprovalsCount,
                'totalBookings' => $totalBookingsCount,
                'upcomingEvents' => $upcomingEventsCount,
                'mediaStorage' => $mediaStoragePercentage
            ],
            'activities' => $activities,
            'contentStatus' => $contentStatus,
            'publishingQueue' => $publishingQueue
        ]);
    }
}
