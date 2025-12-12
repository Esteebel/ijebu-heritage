<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Tradition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'media_id',
        'tags'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
