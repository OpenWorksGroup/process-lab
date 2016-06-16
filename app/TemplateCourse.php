<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateCourse extends Model
{
    protected $fillable = [
        'course_id', 'course_title', 'course_url', 'template_id', 'created_by_user_id', 'updated_by_user_id',
    ];
}
