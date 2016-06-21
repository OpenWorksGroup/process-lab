<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetencyFrameworkCategories extends Model
{
    protected $fillable = [
        'category', 'framework_id', 'created_by_user_id', 'updated_by_user_id',
    ];
}
