<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dynasty;
use App\Models\Media;

class King extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'regnal_name',
        'birth_date',
        'death_year',
        'reign_start_date',
        'reign_end_date',
        'dynasty_id',
        'short_bio',
        'full_bio',
        'portrait_media_id',
        'featured'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'birth_date' => 'date',
        'reign_start_date' => 'date',
        'reign_end_date' => 'date'
    ];

    public function dynasty()
    {
        return $this->belongsTo(Dynasty::class);
    }

    public function portraitMedia()
    {
        return $this->belongsTo(Media::class, 'portrait_media_id');
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'king_media');
    }
}
