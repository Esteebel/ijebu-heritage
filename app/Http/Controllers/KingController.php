<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\King;
use Inertia\Inertia;

class KingController extends BaseController
{
    public function index()
    {
        $kings = King::with('dynasty', 'portraitMedia')->where('featured', true)->get();
        return $this->render('Public/KingsIndex', [
            'kings' => $kings,
            'title' => 'Featured Kings - Ijebu Heritage',
            'description' => 'Explore featured kings from various royal dynasties in our collection.'
        ]);
    }

    public function show(King $king)
    {
        $king->load('dynasty', 'portraitMedia', 'media');
        return $this->render('Public/KingShow', [
            'king' => $king,
            'title' => $king->name . ' - Ijebu Heritage',
            'description' => $king->short_bio
        ]);
    }
}
