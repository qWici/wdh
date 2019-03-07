<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EarlyAccess
 *
 * @property int $id
 * @property string $email
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EarlyAccess whereId($value)
 * @mixin \Eloquent
 */
class EarlyAccess extends Model
{
    protected $fillable = ['email'];
    public $timestamps = false;
}
