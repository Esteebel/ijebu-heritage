<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Media;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('featuredMedia')->get();
        return Inertia::render('Admin/Events/Index', compact('events'));
    }

    public function create()
    {
        $media = Media::all();
        return Inertia::render('Admin/Events/Form', compact('media'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'nullable|string|max:255',
            'featured_media_id' => 'nullable|exists:media,id'
        ]);

        Event::create($validated);

        return redirect()->route('admin.events.index');
    }

    public function show(Event $event)
    {
        $event->load('featuredMedia');
        return Inertia::render('Admin/Events/Show', compact('event'));
    }

    public function edit(Event $event)
    {
        $media = Media::all();
        $event->load('featuredMedia');
        return Inertia::render('Admin/Events/Form', compact('event', 'media'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'nullable|string|max:255',
            'featured_media_id' => 'nullable|exists:media,id'
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index');
    }
}
