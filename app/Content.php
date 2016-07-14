<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'template_id', 'title', 'created_by_user_id', 'template_id',
    ];
}
