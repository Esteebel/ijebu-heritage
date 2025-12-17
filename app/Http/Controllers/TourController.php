<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tour;

class TourController extends BaseController
{
    public function index()
    {
        $tours = Tour::with('featuredMedia')->where('active', true)->get();

        return $this->render('Public/VirtualTour', [
            'tours' => $tours,
            'title' => 'Virtual Tour - Kingdom Museum',
            'description' => 'Take a virtual tour of the Kingdom Museum from the comfort of your home. Explore our royal exhibits and historical artifacts online.'
        ]);
    }
}
