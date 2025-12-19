<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tour::with('featuredMedia')->latest()->get();
        return Inertia::render('Admin/Tours/Index', [
            'tours' => $tours
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Tours/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:100',
            'difficulty' => 'required|in:easy,moderate,difficult',
            'max_participants' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'featured_media_id' => 'nullable|exists:media,id',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', false);

        $tour = Tour::create($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tour $tour)
    {
        $tour->load('featuredMedia');
        return Inertia::render('Admin/Tours/Show', [
            'tour' => $tour
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour)
    {
        $tour->load('featuredMedia');
        return Inertia::render('Admin/Tours/Edit', [
            'tour' => $tour
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string|max:100',
            'difficulty' => 'required|in:easy,moderate,difficult',
            'max_participants' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'featured_media_id' => 'nullable|exists:media,id',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->boolean('is_published', false);

        $tour->update($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        // Delete featured image if it exists
        if ($tour->featured_media_id) {
            $tour->featuredMedia()->delete();
        }

        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully.');
    }
}
