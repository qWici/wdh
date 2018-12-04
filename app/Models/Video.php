<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

class Video extends Model
{
    use Favoriteable;

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
        'lang',
        'published_at'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
