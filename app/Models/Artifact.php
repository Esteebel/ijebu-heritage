<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Artifact extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'era',
        'origin_location',
        'media_id',
        'accession_number',
        'tags'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
