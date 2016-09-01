<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content_id', 'user_id', 'comment',
    ];

    protected $dates = ['deleted_at'];
}
