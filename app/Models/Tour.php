<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'url',
        'active',
        'features',
        'featured_media_id'
    ];

    protected $casts = [
        'features' => 'array',
        'active' => 'boolean'
    ];

    public function featuredMedia()
    {
        return $this->belongsTo(Media::class, 'featured_media_id');
    }
}
