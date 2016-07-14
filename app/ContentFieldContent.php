<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentFieldContent extends Model
{
    protected $fillable = [
        'content_id', 'template_section_field_id', 'type', 'content', 'uri',
    ];
}
