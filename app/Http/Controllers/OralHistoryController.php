<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OralHistory;
use Inertia\Inertia;

class OralHistoryController extends BaseController
{
    public function index()
    {
        $oralHistories = OralHistory::with('featuredMedia', 'audioFile')->where('featured', true)->get();
        return $this->render('Public/OralHistoriesIndex', [
            'oralHistories' => $oralHistories,
            'title' => 'Oral Histories - Ijebu Heritage',
            'description' => 'Listen to folktales, war stories, and personal experiences from the Ijebu oral tradition.'
        ]);
    }

    public function show(OralHistory $oralHistory)
    {
        $oralHistory->load('featuredMedia', 'audioFile');
        return $this->render('Public/OralHistoryShow', [
            'oralHistory' => $oralHistory,
            'title' => $oralHistory->title . ' - Ijebu Heritage',
            'description' => $oralHistory->transcription
        ]);
    }
}
