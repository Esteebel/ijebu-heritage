<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TourController extends BaseController
{
    public function index()
    {
        return $this->render('Public/VirtualTour', [
            'title' => 'Virtual Tour - Kingdom Museum',
            'description' => 'Take a virtual tour of the Kingdom Museum from the comfort of your home. Explore our royal exhibits and historical artifacts online.'
        ]);
    }
}