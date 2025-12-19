<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class OluCorner extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'content',
        'featured_media_id',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean'
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
