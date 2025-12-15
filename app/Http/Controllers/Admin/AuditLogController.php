<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuditLogController extends Controller
{
    public function index()
    {
        // In a real application, you would fetch audit logs from the database
        // For now, we'll create sample data
        $logs = [
            [
                'id' => 1,
                'user' => 'Admin User',
                'action' => 'Created new king profile',
                'model' => 'King',
                'model_id' => 15,
                'timestamp' => '2025-12-10 14:30:00'
            ],
            [
                'id' => 2,
                'user' => 'Editor User',
                'action' => 'Updated event details',
                'model' => 'Event',
                'model_id' => 8,
                'timestamp' => '2025-12-10 12:15:00'
            ],
            [
                'id' => 3,
                'user' => 'Admin User',
                'action' => 'Uploaded media file',
                'model' => 'Media',
                'model_id' => 22,
                'timestamp' => '2025-12-10 10:45:00'
            ],
            [
                'id' => 4,
                'user' => 'Editor User',
                'action' => 'Modified timeline entry',
                'model' => 'Timeline',
                'model_id' => 5,
                'timestamp' => '2025-12-09 16:20:00'
            ],
            [
                'id' => 5,
                'user' => 'Admin User',
                'action' => 'Deleted old advertisement',
                'model' => 'Ad',
                'model_id' => 3,
                'timestamp' => '2025-12-09 09:30:00'
            ]
        ];

        return Inertia::render('Admin/AuditLogs/Index', compact('logs'));
    }
}
