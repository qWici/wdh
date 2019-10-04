<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Suggestion
 *
 * @property int $id
 * @property string $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Suggestion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Suggestion extends Model
{
    protected $fillable = ['type', 'link', 'moderated'];
}
