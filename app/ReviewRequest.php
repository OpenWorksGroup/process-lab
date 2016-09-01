<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content_id', 'user_id', 'reviewed_count',
    ];

    protected $dates = ['deleted_at'];
}
