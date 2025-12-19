<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personality;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PersonalityController extends Controller
{
    public function index()
    {
        $personalities = Personality::with('portrait')->get();
        return Inertia::render('Admin/Personalities/Index', compact('personalities'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/Personalities/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_year' => 'nullable|integer',
            'death_year' => 'nullable|integer',
            'tribe' => 'nullable|string|max:255',
            'contributions' => 'nullable|string',
            'achievements' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('personalities', $filename, 'public');

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

        Personality::create($validated);

        return redirect()->route('admin.personalities.index');
    }

    public function edit(Personality $personality)
    {
        $personality->load('portrait');
        $mediaItems = Media::all();
        return Inertia::render('Admin/Personalities/Form', compact('personality', 'mediaItems'));
    }

    public function update(Request $request, Personality $personality)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_year' => 'nullable|integer',
            'death_year' => 'nullable|integer',
            'tribe' => 'nullable|string|max:255',
            'contributions' => 'nullable|string',
            'achievements' => 'nullable|string',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('personalities', $filename, 'public');

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

        $personality->update($validated);

        return redirect()->route('admin.personalities.index');
    }

    public function destroy(Personality $personality)
    {
        $personality->delete();
        return redirect()->route('admin.personalities.index');
    }
}
