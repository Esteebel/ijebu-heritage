<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\King;
use App\Models\Event;
use App\Models\Artifact;
use App\Models\Media;

class PublicController extends BaseController
{
    public function home()
    {
        // Fetch featured kings for the home page
        $featuredKings = King::with('dynasty', 'portraitMedia')
            ->where('featured', true)
            ->limit(3)
            ->get();

        // Fetch recent artifacts for gallery
        $galleryItems = Artifact::with('media')
            ->whereHas('media')
            ->limit(8)
            ->get();

        // Fetch all kings for past kings section (now with portraitMedia)
        $allKings = King::with('dynasty', 'portraitMedia')
            ->limit(6)
            ->get();

        // Fetch upcoming events
        $upcomingEvents = Event::with('featuredMedia')
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime', 'asc')
            ->limit(4)
            ->get();

        return $this->render('Public/Home', [
            'title' => 'Ijebu Heritage - Home',
            'description' => 'Welcome to the Ijebu Heritage, showcasing the rich history of royal kingdoms through interactive exhibits and artifacts.',
            'featuredKings' => $featuredKings,
            'galleryItems' => $galleryItems,
            'allKings' => $allKings,
            'upcomingEvents' => $upcomingEvents
        ]);
    }
}
