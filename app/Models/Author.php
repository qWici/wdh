<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'site_url', 'language', 'logo', 'about', 'feed_url'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'site_url' => 'string',
        'about' => 'string',
        'language' => 'string',
        'logo' => 'string',
        'feed_url' => 'string',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
