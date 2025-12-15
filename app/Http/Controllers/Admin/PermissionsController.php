<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    public function index()
    {
        // In a real application, you would fetch permissions from the database
        // For now, we'll define them statically
        $permissions = [
            [
                'name' => 'manage_kings',
                'description' => 'Can create, edit, and delete kings',
                'roles' => ['admin', 'editor']
            ],
            [
                'name' => 'manage_events',
                'description' => 'Can create, edit, and delete events',
                'roles' => ['admin', 'editor']
            ],
            [
                'name' => 'manage_media',
                'description' => 'Can upload and manage media files',
                'roles' => ['admin', 'editor']
            ],
            [
                'name' => 'manage_users',
                'description' => 'Can create, edit, and delete users',
                'roles' => ['admin']
            ],
            [
                'name' => 'manage_settings',
                'description' => 'Can modify system settings',
                'roles' => ['admin']
            ],
            [
                'name' => 'view_reports',
                'description' => 'Can view system reports',
                'roles' => ['admin', 'editor']
            ]
        ];

        return Inertia::render('Admin/Permissions/Index', compact('permissions'));
    }

    public function update(Request $request)
    {
        // In a real application, you would update permissions in the database
        // For now, we'll just return a success message
        return redirect()->back()->with('success', 'Permissions updated successfully.');
    }
}
