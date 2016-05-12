<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'title', 'status', 'required_num_reviews', 'required_period_time', 'created_by_user_id', 'updated_by_user_id',
    ];
}
