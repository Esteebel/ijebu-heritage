<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Taggable;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function taggables()
    {
        return $this->hasMany(Taggable::class);
    }
}
