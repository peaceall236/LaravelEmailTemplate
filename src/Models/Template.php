<?php

namespace Alliance\LaravelEmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public const STATUS_PENDING = "pending";
    public const STATUS_PROCESSING = "processing";
    public const STATUS_COMPLETED = "completed";
    public const STATUS_FAILED = "failed";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "template_index", "entry_file", "storage_location", "status"
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laravel_email_templates';

    /**
     * default values
     * 
     * @var string
     */
    protected $attributes = [
        "status" => self::STATUS_PENDING
    ];
}
