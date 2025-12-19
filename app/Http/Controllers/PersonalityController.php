<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personality;
use Inertia\Inertia;

class PersonalityController extends BaseController
{
    public function index()
    {
        $personalities = Personality::with('featuredMedia')->where('featured', true)->get();
        return $this->render('Public/PersonalitiesIndex', [
            'personalities' => $personalities,
            'title' => 'Notable Personalities - Ijebu Heritage',
            'description' => 'Learn about notable Ijebu personalities who have made significant contributions to society.'
        ]);
    }

    public function show(Personality $personality)
    {
        $personality->load('featuredMedia');
        return $this->render('Public/PersonalityShow', [
            'personality' => $personality,
            'title' => $personality->name . ' - Ijebu Heritage',
            'description' => $personality->biography
        ]);
    }
}
