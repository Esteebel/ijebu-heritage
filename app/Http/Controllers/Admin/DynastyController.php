<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dynasty;
use Inertia\Inertia;

class DynastyController extends Controller
{
    public function index()
    {
        $dynasties = Dynasty::all();
        return Inertia::render('Admin/Dynasties/Index', compact('dynasties'));
    }

    public function create()
    {
        return Inertia::render('Admin/Dynasties/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:dynasties',
            'description' => 'nullable|string',
            'start_year' => 'nullable|integer',
            'end_year' => 'nullable|integer',
        ]);

        $dynasty = Dynasty::create($validated);

        return redirect()->route('admin.dynasties.index')->with('success', 'Dynasty created successfully.');
    }

    public function show(Dynasty $dynasty)
    {
        $dynasty->load('kings');
        return Inertia::render('Admin/Dynasties/Show', compact('dynasty'));
    }

    public function edit(Dynasty $dynasty)
    {
        return Inertia::render('Admin/Dynasties/Form', compact('dynasty'));
    }

    public function update(Request $request, Dynasty $dynasty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:dynasties,name,' . $dynasty->id,
            'description' => 'nullable|string',
            'start_year' => 'nullable|integer',
            'end_year' => 'nullable|integer',
        ]);

        $dynasty->update($validated);

        return redirect()->route('admin.dynasties.index')->with('success', 'Dynasty updated successfully.');
    }

    public function destroy(Dynasty $dynasty)
    {
        // Check if dynasty has kings
        if ($dynasty->kings()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete dynasty with associated kings.');
        }

        $dynasty->delete();

        return redirect()->route('admin.dynasties.index')->with('success', 'Dynasty deleted successfully.');
    }
}
