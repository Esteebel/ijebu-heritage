<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class OralHistoryArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'story',
        'category',
        'audio_file_id',
        'featured_media_id',
        'is_featured',
        'storyteller',
        'recorded_date',
        'location',
        'transcript',
        'cultural_context'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'recorded_date' => 'date'
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
