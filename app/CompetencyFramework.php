<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetencyFramework extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'framework', 'created_by_user_id', 'updated_by_user_id',
    ];

    protected $dates = ['deleted_at'];
}
