<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiasporaStory;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiasporaStoryController extends Controller
{
    public function index()
    {
        $diasporaStories = DiasporaStory::with('featuredImage')->get();
        return Inertia::render('Admin/Diaspora/Index', compact('diasporaStories'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/Diaspora/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'story' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'origin_location' => 'nullable|string|max:255',
            'settlement_location' => 'nullable|string|max:255',
            'time_period' => 'nullable|string|max:255',
            'family_connections' => 'nullable|string',
            'cultural_practices' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('diaspora', $filename, 'public');

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

        DiasporaStory::create($validated);

        return redirect()->route('admin.diaspora.stories.index');
    }

    public function edit(DiasporaStory $diasporaStory)
    {
        $diasporaStory->load('featuredImage');
        $mediaItems = Media::all();
        return Inertia::render('Admin/Diaspora/Form', compact('diasporaStory', 'mediaItems'));
    }

    public function update(Request $request, DiasporaStory $diasporaStory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'story' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'origin_location' => 'nullable|string|max:255',
            'settlement_location' => 'nullable|string|max:255',
            'time_period' => 'nullable|string|max:255',
            'family_connections' => 'nullable|string',
            'cultural_practices' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('diaspora', $filename, 'public');

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

        $diasporaStory->update($validated);

        return redirect()->route('admin.diaspora.stories.index');
    }

    public function destroy(DiasporaStory $diasporaStory)
    {
        $diasporaStory->delete();
        return redirect()->route('admin.diaspora.stories.index');
    }
}
