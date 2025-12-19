<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricalEvent;
use Inertia\Inertia;

class HistoricalEventController extends BaseController
{
    public function index()
    {
        $events = HistoricalEvent::with('featuredMedia')->where('featured', true)->orderBy('event_date', 'desc')->get();
        return $this->render('Public/HistoricalEventsIndex', [
            'events' => $events,
            'title' => 'Historical Events - Ijebu Heritage',
            'description' => 'Explore key historical events that shaped the Ijebu people and their culture.'
        ]);
    }

    public function show(HistoricalEvent $event)
    {
        $event->load('featuredMedia');
        return $this->render('Public/HistoricalEventShow', [
            'event' => $event,
            'title' => $event->title . ' - Ijebu Heritage',
            'description' => $event->description
        ]);
    }
}
