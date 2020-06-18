<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelDocuments extends Model
{
    protected $table = "documents";

    protected $fillable = [
        'path', 'active', 'name'
    ];
}
