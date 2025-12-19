<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OralHistory;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OralHistoryController extends Controller
{
    public function index()
    {
        $oralHistories = OralHistory::with('audioFile')->get();
        return Inertia::render('Admin/OralHistories/Index', compact('oralHistories'));
    }

    public function create()
    {
        $mediaItems = Media::where('type', 'audio')->get();
        return Inertia::render('Admin/OralHistories/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'narrator' => 'nullable|string|max:255',
            'recorded_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'transcript' => 'nullable|string',
            'cultural_context' => 'nullable|string',
            'themes' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|max:20480', // 20MB max
        ]);

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $filename = time() . '_' . Str::random(10) . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs('oral_histories', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'audio',
                'mime' => $audio->getMimeType(),
                'size' => $audio->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['media_id'] = $media->id;
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);

        OralHistory::create($validated);

        return redirect()->route('admin.oral.histories.index');
    }

    public function edit(OralHistory $oralHistory)
    {
        $oralHistory->load('audioFile');
        $mediaItems = Media::where('type', 'audio')->get();
        return Inertia::render('Admin/OralHistories/Form', compact('oralHistory', 'mediaItems'));
    }

    public function update(Request $request, OralHistory $oralHistory)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'narrator' => 'nullable|string|max:255',
            'recorded_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'transcript' => 'nullable|string',
            'cultural_context' => 'nullable|string',
            'themes' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|max:20480', // 20MB max
        ]);

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $filename = time() . '_' . Str::random(10) . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs('oral_histories', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'audio',
                'mime' => $audio->getMimeType(),
                'size' => $audio->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['media_id'] = $media->id;
        }

        $validated['is_featured'] = $request->boolean('is_featured', false);

        $oralHistory->update($validated);

        return redirect()->route('admin.oral.histories.index');
    }

    public function destroy(OralHistory $oralHistory)
    {
        $oralHistory->delete();
        return redirect()->route('admin.oral.histories.index');
    }
}
