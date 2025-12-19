<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LanguageItem;
use Inertia\Inertia;

class LanguageItemController extends BaseController
{
    public function index()
    {
        $languageItems = LanguageItem::with('featuredMedia', 'audioFile')->where('featured', true)->get();
        return $this->render('Public/LanguageItemsIndex', [
            'languageItems' => $languageItems,
            'title' => 'Ijebu Language - Ijebu Heritage',
            'description' => 'Explore the Ijebu dialect, words, phrases, and proverbs with pronunciation guides.'
        ]);
    }

    public function show(LanguageItem $languageItem)
    {
        $languageItem->load('featuredMedia', 'audioFile');
        return $this->render('Public/LanguageItemShow', [
            'languageItem' => $languageItem,
            'title' => $languageItem->word_phrase . ' - Ijebu Heritage',
            'description' => $languageItem->meaning
        ]);
    }
}
