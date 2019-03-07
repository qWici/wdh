<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Channel
 *
 * @property int $id
 * @property string $youtube_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $custom_url
 * @property string $image_src
 * @property string|null $country
 * @property int|null $subscriber_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereCustomUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereImageSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereSubscriberCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Channel whereYoutubeId($value)
 * @mixin \Eloquent
 */
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

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
