<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image_src',
        'link',
        'author',
        'date',
        'lang'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'image_src' => 'string',
        'link' => 'string',
        'author' => 'string',
        'date' => 'date:j M Y',
        'lang' => 'string',
    ];
}
