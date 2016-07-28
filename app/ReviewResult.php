<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewResult extends Model
{
    protected $fillable = [
        'review_id', 'results',
    ];
}
