<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Personality extends Model
{
    use HasFactory;

    protected $table = 'personalities';

    protected $fillable = [
        'name',
        'biography',
        'achievements',
        'category',
        'birth_date',
        'death_date',
        'featured_media_id',
        'featured'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'featured' => 'boolean'
    ];

    public function featuredMedia()
    {
        return $this->belongsTo(Media::class, 'featured_media_id');
    }

    // Alias for portrait used in admin views
    public function portrait()
    {
        return $this->featuredMedia();
    }
}
