<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OralHistoryArchive;
use App\Models\Media;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OralHistoryArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $archives = OralHistoryArchive::latest()->get();
        return Inertia::render('Admin/OralHistoryArchives/Index', [
            'archives' => $archives
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/OralHistoryArchives/Create', [
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
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'contributor' => 'required|string|max:255',
            'is_featured' => 'boolean',
            'audio_file_id' => 'nullable|exists:media,id',
            'video_file_id' => 'nullable|exists:media,id',
            'featured_media_id' => 'nullable|exists:media,id',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|max:20480', // 20MB max
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400', // 100MB max
            'audio_url' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
        ]);

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $filename = time() . '_' . Str::random(10) . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs('oral_histories/audio', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'audio',
                'mime' => $audio->getMimeType(),
                'size' => $audio->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['audio_file_id'] = $media->id;
        }

        // Handle video upload if provided
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '_' . Str::random(10) . '.' . $video->getClientOriginalExtension();
            $path = $video->storeAs('oral_histories/video', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'video',
                'mime' => $video->getMimeType(),
                'size' => $video->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['video_file_id'] = $media->id;
        }

        // Handle featured image upload if provided
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('oral_histories/featured', $filename, 'public');

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

        $validated['is_featured'] = $request->boolean('is_featured', false);

        $archive = OralHistoryArchive::create($validated);

        return redirect()->route('admin.oral.history.archives.index')
            ->with('success', 'Oral history archive created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OralHistoryArchive $oralHistoryArchive)
    {
        return Inertia::render('Admin/OralHistoryArchives/Show', [
            'archive' => $oralHistoryArchive
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OralHistoryArchive $oralHistoryArchive)
    {
        $oralHistoryArchive->load('audioFile', 'videoFile', 'featuredMedia');
        $mediaItems = Media::all();
        return Inertia::render('Admin/OralHistoryArchives/Edit', [
            'archive' => $oralHistoryArchive,
            'mediaItems' => $mediaItems
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OralHistoryArchive $oralHistoryArchive)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'contributor' => 'required|string|max:255',
            'is_featured' => 'boolean',
            'audio_file_id' => 'nullable|exists:media,id',
            'video_file_id' => 'nullable|exists:media,id',
            'featured_media_id' => 'nullable|exists:media,id',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|max:20480', // 20MB max
            'video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400', // 100MB max
            'audio_url' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
        ]);

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $filename = time() . '_' . Str::random(10) . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs('oral_histories/audio', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'audio',
                'mime' => $audio->getMimeType(),
                'size' => $audio->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['audio_file_id'] = $media->id;
        }

        // Handle video upload if provided
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time() . '_' . Str::random(10) . '.' . $video->getClientOriginalExtension();
            $path = $video->storeAs('oral_histories/video', $filename, 'public');

            // Create media record
            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'video',
                'mime' => $video->getMimeType(),
                'size' => $video->getSize(),
                'uploaded_by' => auth()->id(),
            ]);

            $validated['video_file_id'] = $media->id;
        }

        // Handle featured image upload if provided
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('oral_histories/featured', $filename, 'public');

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

        $validated['is_featured'] = $request->boolean('is_featured', false);

        $oralHistoryArchive->update($validated);

        return redirect()->route('admin.oral.history.archives.index')
            ->with('success', 'Oral history archive updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OralHistoryArchive $oralHistoryArchive)
    {
        $oralHistoryArchive->delete();

        return redirect()->route('admin.oral.history.archives.index')
            ->with('success', 'Oral history archive deleted successfully.');
    }
}
