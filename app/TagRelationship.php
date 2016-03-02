<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagRelationship extends Model
{
    protected $fillable = [
        'tag_id', 'user_id', 'template_id',
    ];
}
