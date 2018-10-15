<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'twitch'
    ];

    public function tags()
    {
        return $this->hasMany(StreamTag::class);
    }
}
