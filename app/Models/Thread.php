<?php

namespace App\Models;

use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory, RecordsActivity;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'channel_id',
    ];

    protected $with = [
        'creator',
        'channel'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
