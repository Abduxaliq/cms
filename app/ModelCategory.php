<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelCategory extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'parent_id',
        'name',
        'image',
        'style',
        'slug',
        'active'
    ];
}
