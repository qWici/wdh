<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PodcastShow extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'site_url',
        'image_url',
        'language',
        'feed_url'
    ];

    public function podcasts()
    {
        return $this->hasMany(Podcast::class);
    }
}
