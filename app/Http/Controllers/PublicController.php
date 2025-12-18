<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\King;
use App\Models\Event;
use App\Models\Artifact;
use App\Models\Media;
use App\Models\Dynasty;

class PublicController extends BaseController
{
    public function home()
    {
        // Fetch featured kings for the home page
        $featuredKings = King::with('dynasty', 'portraitMedia')
            ->where('featured', true)
            ->limit(3)
            ->get();

        // Fetch current/reigning kings (those without reign_end_date or death_year)
        $currentKings = King::with('dynasty', 'portraitMedia')
            ->whereNull('reign_end_date')
            ->whereNull('death_year')
            ->limit(6)
            ->get();

        // Fetch past kings (those with reign_end_date or death_year)
        $pastKings = King::with('dynasty', 'portraitMedia')
            ->where(function($query) {
                $query->whereNotNull('reign_end_date')
                      ->orWhereNotNull('death_year');
            })
            ->limit(6)
            ->get();

        // Fetch recent artifacts for gallery
        $galleryItems = Artifact::with('media')
            ->whereHas('media')
            ->limit(8)
            ->get();

        // Fetch upcoming events
        $upcomingEvents = Event::with('featuredMedia')
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime', 'asc')
            ->limit(4)
            ->get();

        // Fetch kingdoms for homepage (limit to 4)
        $featuredKingdoms = Dynasty::withCount('kings')
            ->limit(4)
            ->get();

        return $this->render('Public/Home', [
            'title' => 'Ijebu Heritage - Home',
            'description' => 'Welcome to the Ijebu Heritage, showcasing the rich history of royal kingdoms through interactive exhibits and artifacts.',
            'featuredKings' => $featuredKings,
            'galleryItems' => $galleryItems,
            'currentKings' => $currentKings,
            'pastKings' => $pastKings,
            'upcomingEvents' => $upcomingEvents,
            'featuredKingdoms' => $featuredKingdoms
        ]);
    }
}
