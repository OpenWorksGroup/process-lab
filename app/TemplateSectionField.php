<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateSectionField extends Model
{
    protected $fillable = [
        'title', 'description', 'template_section_id', 'required', 'order', 'created_by_user_id', 'updated_by_user_id',
    ];
}
