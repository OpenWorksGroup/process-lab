<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentSectionComment extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'content_id', 'template_section_id', 'feedback_on', 
    ];

    protected $dates = ['deleted_at'];
}
