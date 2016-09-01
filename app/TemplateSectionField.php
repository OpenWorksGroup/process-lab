<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateSectionField extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'field_title', 'description', 'template_section_id', 'required', 'order', 'created_by_user_id', 'updated_by_user_id',
    ];

    protected $dates = ['deleted_at'];
}
