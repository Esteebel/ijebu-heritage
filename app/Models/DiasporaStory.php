<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class DiasporaStory extends Model
{
    use HasFactory;

    protected $table = 'diaspora_stories';

    protected $fillable = [
        'title',
        'storyteller',
        'origin_location',
        'destination',
        'immigration_story',
        'achievements',
        'featured_media_id',
        'featured'
    ];

    protected $casts = [
        'featured' => 'boolean'
    ];

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
