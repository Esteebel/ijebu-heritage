<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class BaseController extends Controller
{
    protected function render($component, $props = [])
    {
        // Add default SEO meta tags
        $defaultMeta = [
            'title' => 'Ijebu Heritage',
            'description' => 'Discover the rich history of royal kingdoms through our interactive museum experience.',
            'keywords' => 'museum, kingdom, history, royalty, kings, queens, artifacts, culture',
        ];

        // Merge with passed props
        $props = array_merge($defaultMeta, $props);

        return Inertia::render($component, $props);
    }
}
