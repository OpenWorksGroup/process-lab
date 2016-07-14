<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content_id', 'template_section_id', 'user_id', 'comment', 'private',
    ];
}
