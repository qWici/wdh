<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StreamTag
 *
 * @property int $id
 * @property string $tag
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stream[] $stream
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag whereTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StreamTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StreamTag extends Model
{
    protected $fillable = [
        'tag'
    ];

    public function stream()
    {
        return $this->belongsToMany(Stream::class, 'tags_to_stream', 'tag_id', 'stream_id');
    }
}
