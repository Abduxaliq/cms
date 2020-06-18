<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPosition extends Model
{
    protected $table = 'position';
    protected $fillable = [
        'name',
        'slug',
        'active',
    ];
}
