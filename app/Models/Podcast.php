<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

class Podcast extends Model
{
    use Favoriteable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'podcast_show_id',
        'title',
        'slug',
        'description',
        'duration',
        'published_at',
        'audio_url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'date:j M Y'
    ];

    public function show()
    {
        return $this->belongsTo(PodcastShow::class, 'podcast_show_id', 'id');
    }
}
