<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use App\Traits\Contentable;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property int $channel_id
 * @property string $youtube_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $image_src
 * @property string|null $lang
 * @property mixed $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Channel $channel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Content[] $contents
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereImageSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Video whereYoutubeId($value)
 * @mixin \Eloquent
 */
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
