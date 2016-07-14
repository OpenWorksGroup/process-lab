<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentStatus extends Model
{
    protected $fillable = [
        'content_id', 'status',
    ];
}
