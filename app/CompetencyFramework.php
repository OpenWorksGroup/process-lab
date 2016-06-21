<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencyFramework extends Model
{
    protected $fillable = [
        'framework', 'created_by_user_id', 'updated_by_user_id',
    ];
}
