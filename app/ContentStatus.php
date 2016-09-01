<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentStatus extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content_id', 'status',
    ];

    protected $dates = ['deleted_at'];
}
