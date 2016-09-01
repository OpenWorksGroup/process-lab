<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagRelationship extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tag_id', 'user_id', 'template_id', 'content_id',
    ];

    protected $dates = ['deleted_at'];
}
