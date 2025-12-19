<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Festival;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FestivalController extends Controller
{
    public function index()
    {
        $festivals = Festival::with('featuredImage')->get();
        return Inertia::render('Admin/Festivals/Index', compact('festivals'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/Festivals/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'origin_story' => 'nullable|string',
            'regberegbe_groups' => 'nullable|string',
            'horsemen_info' => 'nullable|string',
            'dates' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('festivals', $filename, 'public');

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

        Festival::create($validated);

        return redirect()->route('admin.festivals.index');
    }

    public function edit(Festival $festival)
    {
        $festival->load('featuredImage');
        $mediaItems = Media::all();
        return Inertia::render('Admin/Festivals/Form', compact('festival', 'mediaItems'));
    }

    public function update(Request $request, Festival $festival)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'origin_story' => 'nullable|string',
            'regberegbe_groups' => 'nullable|string',
            'horsemen_info' => 'nullable|string',
            'dates' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('festivals', $filename, 'public');

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

        $festival->update($validated);

        return redirect()->route('admin.festivals.index');
    }

    public function destroy(Festival $festival)
    {
        $festival->delete();
        return redirect()->route('admin.festivals.index');
    }
}
