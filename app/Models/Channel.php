<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'youtube_id',
        'title',
        'slug',
        'description',
        'custom_url',
        'image_src',
        'country',
        'subscriber_count'
    ];
}
