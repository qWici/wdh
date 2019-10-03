<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

/**
 * App\Models\Stream
 *
 * @property int $id
 * @property string $name
 * @property string $twitch
 * @property bool $online
 * @property string|null $title
 * @property string|null $language
 * @property string|null $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property mixed|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ChristianKuri\LaravelFavorite\Models\Favorite[] $favorites
 * @property-read int $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StreamTag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream online()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereTwitch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stream whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Stream extends Model
{
    use Favoriteable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'twitch', 'online', 'title', 'language', 'logo', 'twitch_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'twitch' => 'string',
        'online' => 'boolean',
        'title' => 'string',
        'language' => 'string',
        'logo' => 'string',
        'updated_at' => 'date:j M Y'
    ];

    public function tags()
    {
        return $this->belongsToMany(StreamTag::class, 'tags_to_stream', 'stream_id', 'tag_id');
    }

    public function scopeOnline($query)
    {
        return $query->where('online', true);
    }
}
