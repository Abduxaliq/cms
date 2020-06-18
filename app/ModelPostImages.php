<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPostImages extends Model
{
    protected $table = 'post_images';

    protected $fillable = ['post', 'url', 'active'];
}
