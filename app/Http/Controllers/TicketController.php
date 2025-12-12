<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketController extends BaseController
{
    public function index()
    {
        return $this->render('Public/Tickets', [
            'title' => 'Get Tickets - Kingdom Museum',
            'description' => 'Purchase tickets for your visit to the Kingdom Museum. Explore our royal history exhibits, artifacts, and special events.'
        ]);
    }
}