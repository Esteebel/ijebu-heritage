<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Festival extends Model
{
    use HasFactory;

    protected $table = 'festivals';

    protected $fillable = [
        'name',
        'description',
        'origin_story',
        'regberegbe_groups',
        'horsemen_info',
        'featured_media_id',
        'start_date',
        'end_date',
        'featured'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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
