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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laravel_email_templates';
}
