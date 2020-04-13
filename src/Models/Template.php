<?php

namespace Alliance\LaravelEmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "entry_file", "variables"
    ];
}
