<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'status', 'required_num_reviews', 'required_period_time', 'created_by_user_id', 'updated_by_user_id',
    ];

    protected $dates = ['deleted_at'];
}
