<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateRubric extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'template_id', 'competency_framework_id', 'competency_framework_category_id', 'description_1', 'description_2', 'description_3', 'description_4', 'created_by_user_id', 'updated_by_user_id',
    ];

    protected $dates = ['deleted_at'];
}
