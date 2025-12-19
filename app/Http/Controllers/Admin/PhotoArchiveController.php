<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PhotoArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $archives = PhotoArchive::with('featuredImage')->latest()->get();
        return Inertia::render('Admin/PhotoArchives/Index', [
            'archives' => $archives
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/PhotoArchives/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'category' => 'required|string|max:100',
            'featured_image_id' => 'nullable|exists:media,id',
        ]);

        $archive = PhotoArchive::create($validated);

        return redirect()->route('admin.photo.archives.index')
            ->with('success', 'Photo archive created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PhotoArchive $photoArchive)
    {
        $photoArchive->load('featuredImage');
        return Inertia::render('Admin/PhotoArchives/Show', [
            'archive' => $photoArchive
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhotoArchive $photoArchive)
    {
        $photoArchive->load('featuredImage');
        return Inertia::render('Admin/PhotoArchives/Edit', [
            'archive' => $photoArchive
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PhotoArchive $photoArchive)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'category' => 'required|string|max:100',
            'featured_image_id' => 'nullable|exists:media,id',
        ]);

        $photoArchive->update($validated);

        return redirect()->route('admin.photo.archives.index')
            ->with('success', 'Photo archive updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhotoArchive $photoArchive)
    {
        // Delete featured image if it exists
        if ($photoArchive->media_id) {
            $photoArchive->featuredImage()->delete();
        }

        $photoArchive->delete();

        return redirect()->route('admin.photo.archives.index')
            ->with('success', 'Photo archive deleted successfully.');
    }
}
