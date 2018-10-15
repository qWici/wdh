<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
