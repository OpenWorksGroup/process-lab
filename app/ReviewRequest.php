<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewRequest extends Model
{
    protected $fillable = [
        'content_id', 'user_id', 'reviewed_count',
    ];
}
