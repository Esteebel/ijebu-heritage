<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class PhotoArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'decade',
        'media_id',
        'is_featured',
        'date_taken',
        'location',
        'photographer'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'date_taken' => 'date'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    // Alias for featuredImage used in admin views
    public function featuredImage()
    {
        return $this->media();
    }
}
