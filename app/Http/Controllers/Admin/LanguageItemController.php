<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LanguageItem;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LanguageItemController extends Controller
{
    public function index()
    {
        $languageItems = LanguageItem::with('audioFile')->get();
        return Inertia::render('Admin/Language/Index', compact('languageItems'));
    }

    public function create()
    {
        $mediaItems = Media::where('type', 'audio')->get();
        return Inertia::render('Admin/Language/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'word' => 'required|string|max:255',
            'meaning' => 'nullable|string',
            'part_of_speech' => 'nullable|string|max:255',
            'example_sentence' => 'nullable|string',
            'pronunciation' => 'nullable|string|max:255',
            'dialect' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|max:10240', // 10MB max
        ]);

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $filename = time() . '_' . Str::random(10) . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs('language', $filename, 'public');

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

        LanguageItem::create($validated);

        return redirect()->route('admin.language.items.index');
    }

    public function edit(LanguageItem $languageItem)
    {
        $languageItem->load('audioFile');
        $mediaItems = Media::where('type', 'audio')->get();
        return Inertia::render('Admin/Language/Form', compact('languageItem', 'mediaItems'));
    }

    public function update(Request $request, LanguageItem $languageItem)
    {
        $validated = $request->validate([
            'word' => 'required|string|max:255',
            'meaning' => 'nullable|string',
            'part_of_speech' => 'nullable|string|max:255',
            'example_sentence' => 'nullable|string',
            'pronunciation' => 'nullable|string|max:255',
            'dialect' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'audio' => 'nullable|file|mimes:mp3,wav,aac|max:10240', // 10MB max
        ]);

        // Handle audio upload if provided
        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $filename = time() . '_' . Str::random(10) . '.' . $audio->getClientOriginalExtension();
            $path = $audio->storeAs('language', $filename, 'public');

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

        $languageItem->update($validated);

        return redirect()->route('admin.language.items.index');
    }

    public function destroy(LanguageItem $languageItem)
    {
        $languageItem->delete();
        return redirect()->route('admin.language.items.index');
    }
}
