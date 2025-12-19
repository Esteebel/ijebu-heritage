<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Media;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::with('featuredImage')->get();
        return Inertia::render('Admin/Foods/Index', compact('foods'));
    }

    public function create()
    {
        $mediaItems = Media::all();
        return Inertia::render('Admin/Foods/Form', compact('mediaItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preparation_method' => 'nullable|string',
            'cultural_significance' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'region' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('foods', $filename, 'public');

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

        Food::create($validated);

        return redirect()->route('admin.foods.index');
    }

    public function edit(Food $food)
    {
        $food->load('featuredImage');
        $mediaItems = Media::all();
        return Inertia::render('Admin/Foods/Form', compact('food', 'mediaItems'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preparation_method' => 'nullable|string',
            'cultural_significance' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'region' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'media_id' => 'nullable|exists:media,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('foods', $filename, 'public');

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

        $food->update($validated);

        return redirect()->route('admin.foods.index');
    }

    public function destroy(Food $food)
    {
        $food->delete();
        return redirect()->route('admin.foods.index');
    }
}
