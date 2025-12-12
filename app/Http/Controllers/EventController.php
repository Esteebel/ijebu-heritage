<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Inertia\Inertia;

class EventController extends BaseController
{
    public function index()
    {
        $events = Event::with('featuredMedia')->orderBy('start_datetime', 'asc')->get();
        return $this->render('Public/EventsIndex', [
            'events' => $events,
            'title' => 'Events - Kingdom Museum',
            'description' => 'Upcoming events at the Kingdom Museum.'
        ]);
    }

    public function show(Event $event)
    {
        $event->load('featuredMedia');
        return $this->render('Public/EventShow', [
            'event' => $event,
            'title' => $event->title . ' - Kingdom Museum',
            'description' => $event->description
        ]);
    }
}
