<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $site_url
 * @property string $language
 * @property string $logo
 * @property string $about
 * @property string $feed_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereFeedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereSiteUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereSlug($value)
 * @mixin \Eloquent
 */
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
