<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoricalEvent;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HistoricalEventController extends Controller
{
    public function index()
    {
        $events = HistoricalEvent::with('featuredImage')->get();
        return Inertia::render('Admin/HistoricalEvents/Index', compact('events'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/HistoricalEvents/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'significance' => 'nullable|string',
            'key_figures' => 'nullable|string',
            'sources' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('historical_events', $filename, 'public');

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

        HistoricalEvent::create($validated);

        return redirect()->route('admin.historical.events.index');
    }

    public function edit(HistoricalEvent $event)
    {
        $event->load('featuredImage');
        $mediaItems = Media::all();
        return Inertia::render('Admin/HistoricalEvents/Form', compact('event', 'mediaItems'));
    }

    public function update(Request $request, HistoricalEvent $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'significance' => 'nullable|string',
            'key_figures' => 'nullable|string',
            'sources' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('historical_events', $filename, 'public');

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

        $event->update($validated);

        return redirect()->route('admin.historical.events.index');
    }

    public function destroy(HistoricalEvent $event)
    {
        $event->delete();
        return redirect()->route('admin.historical.events.index');
    }
}
