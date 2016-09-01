<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateSection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'section_title', 'description', 'template_id', 'order', 'created_by_user_id', 'updated_by_user_id',
    ];

    protected $dates = ['deleted_at'];
}
