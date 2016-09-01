<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewResult extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'review_id', 'results',
    ];

    protected $dates = ['deleted_at'];
}
