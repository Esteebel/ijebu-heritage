<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Ticket;

class TicketController extends BaseController
{
    public function index()
    {
        $tickets = Ticket::where('active', true)->get();

        return $this->render('Public/Tickets', [
            'tickets' => $tickets,
            'title' => 'Get Tickets - Kingdom Museum',
            'description' => 'Purchase tickets for your visit to the Kingdom Museum. Explore our royal history exhibits, artifacts, and special events.'
        ]);
    }
}
