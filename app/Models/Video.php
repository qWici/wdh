<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'youtube_id',
        'title',
        'slug',
        'description',
        'image_src',
        'viewCount',
        'published_at'
    ];
}
