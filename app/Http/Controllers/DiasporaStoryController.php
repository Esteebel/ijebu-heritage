<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiasporaStory;
use Inertia\Inertia;

class DiasporaStoryController extends BaseController
{
    public function index()
    {
        $diasporaStories = DiasporaStory::with('featuredMedia')->where('featured', true)->get();
        return $this->render('Public/DiasporaStoriesIndex', [
            'diasporaStories' => $diasporaStories,
            'title' => 'Diaspora Stories - Ijebu Heritage',
            'description' => 'Discover the experiences and achievements of the Ijebu diaspora community around the world.'
        ]);
    }

    public function show(DiasporaStory $diasporaStory)
    {
        $diasporaStory->load('featuredMedia');
        return $this->render('Public/DiasporaStoryShow', [
            'diasporaStory' => $diasporaStory,
            'title' => $diasporaStory->title . ' - Ijebu Heritage',
            'description' => $diasporaStory->immigration_story
        ]);
    }
}
