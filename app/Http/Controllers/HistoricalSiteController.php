<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricalSite;
use Inertia\Inertia;

class HistoricalSiteController extends BaseController
{
    public function index()
    {
        $sites = HistoricalSite::with('featuredMedia')->where('featured', true)->get();
        return $this->render('Public/SitesIndex', [
            'sites' => $sites,
            'title' => 'Historical Sites - Ijebu Heritage',
            'description' => 'Explore the historical landmarks and sacred sites of the Ijebu people.'
        ]);
    }

    public function show(HistoricalSite $site)
    {
        $site->load('featuredMedia');
        return $this->render('Public/SiteShow', [
            'site' => $site,
            'title' => $site->name . ' - Ijebu Heritage',
            'description' => $site->description
        ]);
    }
}
