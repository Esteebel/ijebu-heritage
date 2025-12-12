<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\King;
use Inertia\Inertia;

class TimelineController extends BaseController
{
    public function index()
    {
        $kings = King::orderBy('reign_start_date')->get([
            'id',
            'name',
            'regnal_name',
            'reign_start_date',
            'reign_end_date',
            'dynasty_id'
        ]);

        return $this->render('Public/Timeline', [
            'kings' => $kings,
            'title' => 'Royal Timeline - Ijebu Heritage',
            'description' => 'Explore the chronological timeline of royal reigns throughout history.'
        ]);
    }
}
