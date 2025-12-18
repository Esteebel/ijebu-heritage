<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\King;
use App\Models\Dynasty;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class KingController extends Controller
{
    public function index()
    {
        $kings = King::with('dynasty', 'portraitMedia')->get();
        return Inertia::render('Admin/Kings/Index', compact('kings'));
    }

    public function create()
    {
        $dynasties = Dynasty::all();
        return Inertia::render('Admin/Kings/Form', compact('dynasties'));
    }

    public function store(Request $request)
    {
        // Handle empty string values for nullable integer fields
        if ($request->death_year === '') {
            $request->merge(['death_year' => null]);
        }
        if ($request->dynasty_id === '') {
            $request->merge(['dynasty_id' => null]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'regnal_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'death_year' => 'nullable|integer',
            'reign_start_date' => 'nullable|date',
            'reign_end_date' => 'nullable|date',
            'dynasty_id' => 'nullable|exists:dynasties,id',
            'short_bio' => 'nullable|string',
            'full_bio' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'portrait' => 'nullable|image|max:5120', // 5MB max
        ]);

        // Convert featured to proper boolean
        $validated['featured'] = filter_var($validated['featured'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Handle portrait upload
        $portraitMediaId = null;
        if ($request->hasFile('portrait')) {
            $portraitMediaId = $this->uploadPortrait($request->file('portrait'));
        }

        // Create the king
        $king = King::create(array_merge($validated, [
            'portrait_media_id' => $portraitMediaId
        ]));

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $this->attachAdditionalImages($king, $request->file('additional_images'));
        }

        return redirect()->route('admin.kings.index');
    }

    public function show(King $king)
    {
        $king->load('dynasty', 'portraitMedia', 'media');
        return Inertia::render('Admin/Kings/Show', compact('king'));
    }

    public function edit(King $king)
    {
        $dynasties = Dynasty::all();
        $king->load('dynasty', 'portraitMedia', 'media');
        return Inertia::render('Admin/Kings/Form', compact('king', 'dynasties'));
    }

    public function update(Request $request, King $king)
    {
        // Handle empty string values for nullable integer fields
        if ($request->death_year === '') {
            $request->merge(['death_year' => null]);
        }
        if ($request->dynasty_id === '') {
            $request->merge(['dynasty_id' => null]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'regnal_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'death_year' => 'nullable|integer',
            'reign_start_date' => 'nullable|date',
            'reign_end_date' => 'nullable|date',
            'dynasty_id' => 'nullable|exists:dynasties,id',
            'short_bio' => 'nullable|string',
            'full_bio' => 'nullable|string',
            'featured' => 'nullable|boolean',
            'portrait' => 'nullable|image|max:5120', // 5MB max
        ]);

        // Convert featured to proper boolean
        $validated['featured'] = filter_var($validated['featured'] ?? false, FILTER_VALIDATE_BOOLEAN);

        // Handle portrait upload
        if ($request->hasFile('portrait')) {
            // Delete old portrait if exists
            if ($king->portrait_media_id) {
                $oldPortrait = Media::find($king->portrait_media_id);
                if ($oldPortrait) {
                    Storage::disk('public')->delete($oldPortrait->path);
                    $oldPortrait->delete();
                }
            }

            $portraitMediaId = $this->uploadPortrait($request->file('portrait'));
            $validated['portrait_media_id'] = $portraitMediaId;
        }

        // Update the king
        $king->update($validated);

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $this->attachAdditionalImages($king, $request->file('additional_images'));
        }

        // Handle removed additional images
        if ($request->has('removed_additional_images')) {
            $this->detachAdditionalImages($king, $request->removed_additional_images);
        }

        return redirect()->route('admin.kings.index');
    }

    public function destroy(King $king)
    {
        // Delete portrait if exists
        if ($king->portrait_media_id) {
            $portrait = Media::find($king->portrait_media_id);
            if ($portrait) {
                Storage::disk('public')->delete($portrait->path);
                $portrait->delete();
            }
        }

        // Delete additional images
        $king->media->each(function ($media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        });

        $king->delete();
        return redirect()->route('admin.kings.index');
    }

    private function uploadPortrait($file)
    {
        $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('media', $filename, 'public');

        $media = Media::create([
            'filename' => $filename,
            'path' => $path,
            'type' => 'image',
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploaded_by' => auth()->id()
        ]);

        return $media->id;
    }

    private function attachAdditionalImages($king, $files)
    {
        foreach ($files as $file) {
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('media', $filename, 'public');

            $media = Media::create([
                'filename' => $filename,
                'path' => $path,
                'type' => 'image',
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
                'uploaded_by' => auth()->id()
            ]);

            // Attach to king
            $king->media()->attach($media->id);
        }
    }

    private function detachAdditionalImages($king, $mediaIds)
    {
        foreach ($mediaIds as $mediaId) {
            // Detach from king
            $king->media()->detach($mediaId);

            // Delete media file and record
            $media = Media::find($mediaId);
            if ($media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
        }
    }
}
