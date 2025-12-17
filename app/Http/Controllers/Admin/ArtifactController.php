<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtifactController extends Controller
{
    public function index()
    {
        $artifacts = Artifact::with('media')->get();
        return Inertia::render('Admin/Artifacts/Index', compact('artifacts'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/Artifacts/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'era' => 'nullable|string|max:255',
            'origin_location' => 'nullable|string|max:255',
            'accession_number' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('artifacts', $filename, 'public');

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

        Artifact::create($validated);

        return redirect()->route('admin.artifacts.index');
    }

    public function edit(Artifact $artifact)
    {
        $artifact->load('media');
        $mediaItems = Media::all();
        return Inertia::render('Admin/Artifacts/Form', compact('artifact', 'mediaItems'));
    }

    public function update(Request $request, Artifact $artifact)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'era' => 'nullable|string|max:255',
            'origin_location' => 'nullable|string|max:255',
            'accession_number' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('artifacts', $filename, 'public');

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

        $artifact->update($validated);

        return redirect()->route('admin.artifacts.index');
    }

    public function destroy(Artifact $artifact)
    {
        $artifact->delete();
        return redirect()->route('admin.artifacts.index');
    }
}
