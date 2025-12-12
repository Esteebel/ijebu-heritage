<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PageRevision extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_type',
        'page_id',
        'data_json',
        'edited_by'
    ];

    protected $casts = [
        'data_json' => 'array'
    ];

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
