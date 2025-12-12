<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slot_location',
        'ad_code',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];
}
