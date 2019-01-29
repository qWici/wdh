<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use App\Traits\Contentable;

class Video extends Model
{
    use Favoriteable, Contentable;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'date:j M Y'
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
