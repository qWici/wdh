<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Content
 *
 * @property string $contentable_type
 * @property int $contentable_id
 * @property string $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $contentable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereContentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereContentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Content whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Content extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contentable_id', 'contentable_type', 'updated_at'];

    public $timestamps = false;

    public function contentable()
    {
        return $this->morphTo();
    }
}
