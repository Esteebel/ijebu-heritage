<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class LanguageItem extends Model
{
    use HasFactory;

    protected $table = 'language_items';

    protected $fillable = [
        'word_phrase',
        'pronunciation_guide',
        'meaning',
        'usage_example',
        'category',
        'audio_file_id',
        'featured_media_id',
        'featured'
    ];

    protected $casts = [
        'featured' => 'boolean'
    ];

    public function audioFile()
    {
        return $this->belongsTo(Media::class, 'audio_file_id');
    }

    public function featuredMedia()
    {
        return $this->belongsTo(Media::class, 'featured_media_id');
    }

    // Alias for featuredImage used in admin views
    public function featuredImage()
    {
        return $this->featuredMedia();
    }
}
