<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateSection extends Model
{
    protected $fillable = [
        'title', 'description', 'template_id', 'required', 'order', 'created_by_user_id', 'updated_by_user_id',
    ];
}
