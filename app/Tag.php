<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag', 'label', 'type', 'created_by', 'user_id',
    ];
}
