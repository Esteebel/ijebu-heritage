<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class HistoricalSite extends Model
{
    use HasFactory;

    protected $table = 'historical_sites';

    protected $fillable = [
        'name',
        'description',
        'location',
        'coordinates',
        'historical_significance',
        'featured_media_id',
        'preservation_status',
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
