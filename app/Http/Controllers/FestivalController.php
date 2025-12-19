<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Festival;
use Inertia\Inertia;

class FestivalController extends BaseController
{
    public function index()
    {
        $festivals = Festival::with('featuredMedia')->where('featured', true)->get();
        return $this->render('Public/FestivalsIndex', [
            'festivals' => $festivals,
            'title' => 'Festivals - Ijebu Heritage',
            'description' => 'Explore the rich cultural festivals of the Ijebu people.'
        ]);
    }

    public function show(Festival $festival)
    {
        $festival->load('featuredMedia');
        return $this->render('Public/FestivalShow', [
            'festival' => $festival,
            'title' => $festival->name . ' - Ijebu Heritage',
            'description' => $festival->description
        ]);
    }
}
