<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
