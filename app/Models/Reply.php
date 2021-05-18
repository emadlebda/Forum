<?php

namespace App\Models;

use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory, Favoritable;

    protected $fillable = [
        'thread_id',
        'user_id',
        'body',
    ];

    protected $with = [
        'owner',
        'favorites'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
