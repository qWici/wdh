<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyAccess extends Model
{
    protected $fillable = ['email'];
    public $timestamps = false;
}
