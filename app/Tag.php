<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tag', 'label', 'type', 'created_by', 'user_id',
    ];

    protected $dates = ['deleted_at'];
}
