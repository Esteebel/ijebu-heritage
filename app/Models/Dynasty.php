<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\King;

class Dynasty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_year',
        'end_year'
    ];

    public function kings()
    {
        return $this->hasMany(King::class);
    }
}
