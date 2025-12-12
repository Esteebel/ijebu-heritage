<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artifact;
use Inertia\Inertia;

class ArtifactController extends BaseController
{
    public function index()
    {
        $artifacts = Artifact::with('media')->get();
        return $this->render('Public/ArtifactsIndex', [
            'artifacts' => $artifacts,
            'title' => 'Exhibits - Kingdom Museum',
            'description' => 'Explore our collection of royal artifacts and exhibits.'
        ]);
    }

    public function show(Artifact $artifact)
    {
        $artifact->load('media');
        return $this->render('Public/ArtifactShow', [
            'artifact' => $artifact,
            'title' => $artifact->title . ' - Kingdom Museum',
            'description' => $artifact->description
        ]);
    }
}
