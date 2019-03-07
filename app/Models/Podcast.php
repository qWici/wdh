<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use App\Traits\Contentable;

/**
 * App\Models\Podcast
 *
 * @property int $id
 * @property int $podcast_show_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $duration
 * @property mixed $published_at
 * @property string $audio_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @property-read \App\Models\PodcastShow $show
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereAudioUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast wherePodcastShowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Podcast whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Podcast extends Model
{
    use Favoriteable, Contentable;

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
