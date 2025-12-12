<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\King;
use Inertia\Inertia;

class KingController extends Controller
{
    public function index()
    {
        $kings = King::with('dynasty', 'portraitMedia')->get();
        return Inertia::render('Admin/Kings/Index', compact('kings'));
    }

    public function create()
    {
        return Inertia::render('Admin/Kings/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'regnal_name' => 'nullable|string|max:255',
            'birth_year' => 'nullable|integer',
            'death_year' => 'nullable|integer',
            'reign_start_date' => 'nullable|date',
            'reign_end_date' => 'nullable|date',
            'dynasty_id' => 'nullable|exists:dynasties,id',
            'short_bio' => 'nullable|string',
            'full_bio' => 'nullable|string',
            'portrait_media_id' => 'nullable|exists:media,id',
            'featured' => 'boolean'
        ]);

        King::create($validated);

        return redirect()->route('admin.kings.index');
    }

    public function show(King $king)
    {
        $king->load('dynasty', 'portraitMedia', 'media');
        return Inertia::render('Admin/Kings/Show', compact('king'));
    }

    public function edit(King $king)
    {
        $king->load('dynasty', 'portraitMedia');
        return Inertia::render('Admin/Kings/Form', compact('king'));
    }

    public function update(Request $request, King $king)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'regnal_name' => 'nullable|string|max:255',
            'birth_year' => 'nullable|integer',
            'death_year' => 'nullable|integer',
            'reign_start_date' => 'nullable|date',
            'reign_end_date' => 'nullable|date',
            'dynasty_id' => 'nullable|exists:dynasties,id',
            'short_bio' => 'nullable|string',
            'full_bio' => 'nullable|string',
            'portrait_media_id' => 'nullable|exists:media,id',
            'featured' => 'boolean'
        ]);

        $king->update($validated);

        return redirect()->route('admin.kings.index');
    }

    public function destroy(King $king)
    {
        $king->delete();
        return redirect()->route('admin.kings.index');
    }
}
