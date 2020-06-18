<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPage extends Model
{
    protected $table='page';
    protected $fillable = ['title', 'content', 'slug', 'active'];
}
