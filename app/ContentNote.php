<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentNote extends Model
{
	protected $fillable = [
        'content_id', 'note',
    ];
}
