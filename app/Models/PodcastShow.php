<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PodcastShow
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $site_url
 * @property string $image_url
 * @property string $language
 * @property string $feed_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Podcast[] $podcasts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PodcastShow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
