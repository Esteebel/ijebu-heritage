<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\PublishingQueue;
use Illuminate\Http\Request;

class PublishingQueueController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publishingQueueItems = PublishingQueue::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return $this->render('Admin/Publishing/Queue', [
            'publishingQueueItems' => $publishingQueueItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->render('Admin/Publishing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:king,event,artifact,tour,ticket',
            'description' => 'nullable|string',
            'status' => 'required|string|in:draft,ready,published',
            'scheduled_at' => 'nullable|date'
        ]);

        $validated['user_id'] = auth()->id();

        PublishingQueue::create($validated);

        return redirect()->route('admin.publishing.queue.index')
            ->with('success', 'Publishing queue item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PublishingQueue $publishingQueue)
    {
        $publishingQueue->load('user');
        return $this->render('Admin/Publishing/Show', [
            'publishingQueueItem' => $publishingQueue
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublishingQueue $publishingQueue)
    {
        return $this->render('Admin/Publishing/Edit', [
            'publishingQueueItem' => $publishingQueue
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublishingQueue $publishingQueue)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:king,event,artifact,tour,ticket',
            'description' => 'nullable|string',
            'status' => 'required|string|in:draft,ready,published',
            'scheduled_at' => 'nullable|date'
        ]);

        $publishingQueue->update($validated);

        return redirect()->route('admin.publishing.queue.index')
            ->with('success', 'Publishing queue item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublishingQueue $publishingQueue)
    {
        $publishingQueue->delete();

        return redirect()->route('admin.publishing.queue.index')
            ->with('success', 'Publishing queue item deleted successfully.');
    }

    /**
     * Publish a queue item
     */
    public function publish(PublishingQueue $publishingQueue)
    {
        $publishingQueue->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return redirect()->back()
            ->with('success', 'Item published successfully.');
    }
}
