<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Models\Media;
use Inertia\Inertia;

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
            'media_id' => 'nullable|exists:media,id',
            'accession_number' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
        ]);

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
            'media_id' => 'nullable|exists:media,id',
            'accession_number' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
        ]);

        $artifact->update($validated);

        return redirect()->route('admin.artifacts.index');
    }

    public function destroy(Artifact $artifact)
    {
        $artifact->delete();
        return redirect()->route('admin.artifacts.index');
    }
}
