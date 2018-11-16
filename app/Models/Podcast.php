<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
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

    public function show()
    {
        return $this->belongsTo(PodcastShow::class, 'podcast_show_id', 'id');
    }
}
