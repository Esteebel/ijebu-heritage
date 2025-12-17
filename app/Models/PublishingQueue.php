<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishingQueue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'user_id',
        'content_id',
        'status',
        'scheduled_at',
        'published_at',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
