<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_id', 'title', 'created_by_user_id', 'template_id',
    ];

    protected $dates = ['deleted_at'];
}
