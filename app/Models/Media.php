<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\King;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'type',
        'mime',
        'width',
        'height',
        'size',
        'caption',
        'credit',
        'uploaded_by'
    ];

    protected $casts = [
        'type' => 'string'
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function kings()
    {
        return $this->belongsToMany(King::class, 'king_media');
    }
}
