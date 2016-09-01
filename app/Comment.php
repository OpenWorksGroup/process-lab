<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;

    protected $fillable = [
        'content_id', 'template_section_id', 'user_id', 'comment', 'private',
    ];

    protected $dates = ['deleted_at'];
}
