<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateRubric extends Model
{
    protected $fillable = [
        'template_id', 'competency_framework_id', 'competency_framework_category_id', 'description_1', 'description_2', 'description_3', 'description_4', 'created_by_user_id', 'updated_by_user_id',
    ];
}
