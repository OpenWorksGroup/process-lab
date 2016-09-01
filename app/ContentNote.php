<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentNote extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
        'content_id', 'note',
    ];
    
    protected $dates = ['deleted_at'];
}
