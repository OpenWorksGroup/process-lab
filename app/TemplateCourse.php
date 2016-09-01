<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateCourse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id', 'course_title', 'course_url', 'template_id', 'created_by_user_id', 'updated_by_user_id',
    ];

    protected $dates = ['deleted_at'];
}
