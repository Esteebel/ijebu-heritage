<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::with('uploader')->get();
        return Inertia::render('Admin/Media/Index', compact('media'));
    }

    public function create()
    {
        return Inertia::render('Admin/Media/Upload');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,pdf,avi,mov,wmv,mp3,wav,ogg|max:20480', // 20MB max
            'caption' => 'nullable|string|max:255',
            'credit' => 'nullable|string|max:255'
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('media', $filename, 'public');

            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => $this->getMediaType($file->getClientOriginalExtension()),
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'caption' => $validated['caption'] ?? null,
                'credit' => $validated['credit'] ?? null,
                'uploaded_by' => auth()->id()
            ]);
        }

        return redirect()->route('admin.media.index');
    }

    public function show(Media $medium)
    {
        return Inertia::render('Admin/Media/Show', compact('medium'));
    }

    public function edit(Media $medium)
    {
        return Inertia::render('Admin/Media/Edit', compact('medium'));
    }

    public function update(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
            'credit' => 'nullable|string|max:255'
        ]);

        $medium->update($validated);

        return redirect()->route('admin.media.index');
    }

    public function destroy(Media $medium)
    {
        // Delete file from storage
        Storage::disk('public')->delete($medium->path);

        $medium->delete();
        return redirect()->route('admin.media.index');
    }

    public function bulkUpload(Request $request)
    {
        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,pdf,avi,mov,wmv,mp3,wav,ogg|max:20480' // 20MB max each
        ]);

        $uploadedMedia = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('media', $filename, 'public');

                $media = Media::create([
                    'filename' => $filename,
                    'path' => $path,
                    'type' => $this->getMediaType($file->getClientOriginalExtension()),
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by' => auth()->id()
                ]);

                $uploadedMedia[] = $media;
            }
        }

        return redirect()->route('admin.media.index')->with('success', count($uploadedMedia) . ' files uploaded successfully.');
    }

    private function getMediaType($extension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv'];
        $audioExtensions = ['mp3', 'wav', 'ogg'];
        $documentExtensions = ['pdf'];

        $extension = strtolower($extension);

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($extension, $videoExtensions)) {
            return 'video';
        } elseif (in_array($extension, $audioExtensions)) {
            return 'audio';
        } elseif (in_array($extension, $documentExtensions)) {
            return 'document';
        } else {
            return 'other';
        }
    }
}
