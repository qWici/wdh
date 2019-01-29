<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;
use App\Traits\Contentable;

class Article extends Model
{
    use Favoriteable, Contentable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'image_src',
        'link',
        'author_id',
        'date',
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date:j M Y'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
