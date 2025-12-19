<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class HistoricalEvent extends Model
{
    use HasFactory;

    protected $table = 'historical_events';

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'significance',
        'featured_media_id',
        'location',
        'featured'
    ];

    protected $casts = [
        'event_date' => 'date',
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
