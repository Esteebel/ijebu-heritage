<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoricalSite;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HistoricalSiteController extends Controller
{
    public function index()
    {
        $sites = HistoricalSite::with('featuredImage')->get();
        return Inertia::render('Admin/Sites/Index', compact('sites'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/Sites/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'historical_period' => 'nullable|string|max:255',
            'significance' => 'nullable|string',
            'preservation_status' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('sites', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'image',
                'mime' => $image->getMimeType(),
                'size' => $image->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['media_id'] = $media->id;
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);

        HistoricalSite::create($validated);

        return redirect()->route('admin.sites.index');
    }

    public function edit(HistoricalSite $site)
    {
        $site->load('featuredImage');
        $mediaItems = Media::all();
        return Inertia::render('Admin/Sites/Form', compact('site', 'mediaItems'));
    }

    public function update(Request $request, HistoricalSite $site)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'historical_period' => 'nullable|string|max:255',
            'significance' => 'nullable|string',
            'preservation_status' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('sites', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'image',
                'mime' => $image->getMimeType(),
                'size' => $image->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['media_id'] = $media->id;
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);

        $site->update($validated);

        return redirect()->route('admin.sites.index');
    }

    public function destroy(HistoricalSite $site)
    {
        $site->delete();
        return redirect()->route('admin.sites.index');
    }
}
