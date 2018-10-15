<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamTag extends Model
{
    protected $fillable = [
        'user_id',
        'tag'
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }
}
