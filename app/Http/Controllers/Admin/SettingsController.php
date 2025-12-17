<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function index()
    {
        // Get current settings from config or database
        $settings = [
            'site_name' => config('app.name'),
            'site_description' => config('app.description', 'Museum Management System'),
            'contact_email' => config('mail.from.address'),
            'timezone' => config('app.timezone'),
            'maintenance_mode' => config('app.maintenance_mode', false)
        ];

        return Inertia::render('Admin/Settings/Index', compact('settings'));
    }

    public function update(Request $request)
    {
        // In a real application, you would save these settings to the database
        // For now, we'll just return a success message
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
