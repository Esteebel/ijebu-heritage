<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'active',
        'benefits'
    ];

    protected $casts = [
        'benefits' => 'array',
        'price' => 'decimal:2',
        'active' => 'boolean'
    ];

    /**
     * Scope a query to only include published tickets.
     */
    public function scopePublished($query)
    {
        return $query->where('active', true);
    }
}
