<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentSectionComment extends Model
{
    protected $fillable = [
        'content_id', 'template_section_id', 'feedback_on', 
    ];
}
