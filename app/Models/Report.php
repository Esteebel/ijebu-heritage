<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_media_id',
        'published_at',
        'created_by'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function fileMedia()
    {
        return $this->belongsTo(Media::class, 'file_media_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
