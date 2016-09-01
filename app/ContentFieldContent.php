<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentFieldContent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content_id', 'template_section_field_id', 'type', 'content', 'uri',
    ];

    protected $dates = ['deleted_at'];
}
