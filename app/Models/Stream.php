<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'twitch', 'online', 'title', 'language', 'logo'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'twitch' => 'string',
        'online' => 'boolean',
        'title' => 'string',
        'language' => 'string',
        'logo' => 'string',
    ];

    public function tags()
    {
        return $this->belongsToMany(StreamTag::class, 'tags_to_stream', 'stream_id', 'tag_id');
    }

    public function scopeOnline($query)
    {
        return $query->where('online', true);
    }
}
