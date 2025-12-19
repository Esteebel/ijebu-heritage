<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OluCorner;
use App\Models\Media;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OluCornerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = OluCorner::latest()->get();
        return Inertia::render('Admin/OluCorner/Index', [
            'entries' => $entries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/OluCorner/Create', [
            'mediaItems' => $mediaItems
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'featured_media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('olu_corner', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'image',
                'mime' => $image->getMimeType(),
                'size' => $image->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['featured_media_id'] = $media->id;
        }

        $validated['is_published'] = $request->boolean('is_published', false);

        $entry = OluCorner::create($validated);

        return redirect()->route('admin.olu.corner.index')
            ->with('success', 'Entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OluCorner $oluCorner)
    {
        return Inertia::render('Admin/OluCorner/Show', [
            'entry' => $oluCorner
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OluCorner $oluCorner)
    {
        $oluCorner->load('featuredMedia');
        $mediaItems = Media::all();
        return Inertia::render('Admin/OluCorner/Edit', [
            'entry' => $oluCorner,
            'mediaItems' => $mediaItems
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OluCorner $oluCorner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'featured_media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('olu_corner', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'image',
                'mime' => $image->getMimeType(),
                'size' => $image->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['featured_media_id'] = $media->id;
        }

        $validated['is_published'] = $request->boolean('is_published', false);

        $oluCorner->update($validated);

        return redirect()->route('admin.olu.corner.index')
            ->with('success', 'Entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OluCorner $oluCorner)
    {
        $oluCorner->delete();

        return redirect()->route('admin.olu.corner.index')
            ->with('success', 'Entry deleted successfully.');
    }
}
