<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\King;

class PublicController extends BaseController
{
    public function home()
    {
        // Fetch featured kings for the home page
        $featuredKings = King::with('dynasty')
            ->where('featured', true)
            ->limit(3)
            ->get();

        return $this->render('Public/Home', [
            'title' => 'Ijebu Heritage - Home',
            'description' => 'Welcome to the Ijebu Heritage, showcasing the rich history of royal kingdoms through interactive exhibits and artifacts.',
            'featuredKings' => $featuredKings
        ]);
    }
}
