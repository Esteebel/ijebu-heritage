<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class OralHistory extends Model
{
    use HasFactory;

    protected $table = 'oral_histories';

    protected $fillable = [
        'title',
        'storyteller',
        'recording_date',
        'transcription',
        'category',
        'audio_file_id',
        'featured_media_id',
        'featured'
    ];

    protected $casts = [
        'recording_date' => 'date',
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
