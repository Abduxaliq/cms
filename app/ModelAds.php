<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelAds extends Model
{
    protected $table = 'advertising';

    protected $fillable = ['position', 'script_text'];
}
