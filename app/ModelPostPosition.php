<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPostPosition extends Model
{
    protected $table = 'post_position';

    protected $fillable = ['posts_id', 'position_id'];
}
