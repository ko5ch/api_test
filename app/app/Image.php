<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public const DEFAULT_URL = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['url'];

}
