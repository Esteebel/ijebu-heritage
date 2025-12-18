<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dynasty;
use Inertia\Inertia;

class KingdomController extends BaseController
{
    public function index()
    {
        // Fetch all dynasties (kingdoms) with their kings count
        $kingdoms = Dynasty::withCount('kings')->get();

        return $this->render('Public/Kingdoms/Index', [
            'kingdoms' => $kingdoms,
            'title' => 'Kingdoms - Ijebu Heritage',
            'description' => 'Explore the rich history of various kingdoms and their royal dynasties.'
        ]);
    }

    public function show(Dynasty $kingdom)
    {
        // Load the kingdom with its kings and their media
        $kingdom->load(['kings' => function($query) {
            $query->orderBy('reign_start_date')->with('portraitMedia');
        }]);

        return $this->render('Public/Kingdoms/Show', [
            'kingdom' => $kingdom,
            'title' => $kingdom->name . ' - Ijebu Heritage',
            'description' => $kingdom->description
        ]);
    }

    public function adminIndex()
    {
        // Fetch all dynasties (kingdoms) with their kings count for admin panel
        $kingdoms = Dynasty::withCount('kings')->get();

        return Inertia::render('Admin/Kingdoms/Index', [
            'kingdoms' => $kingdoms
        ]);
    }

    public function adminShow(Dynasty $kingdom)
    {
        // Load the kingdom with its kings for admin panel
        $kingdom->load('kings');

        return Inertia::render('Admin/Kingdoms/Show', [
            'kingdom' => $kingdom
        ]);
    }
}
