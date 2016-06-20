<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateSection extends Model
{
    protected $fillable = [
        'section_title', 'description', 'template_id', 'order', 'created_by_user_id', 'updated_by_user_id',
    ];
}
