<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelSettings extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'title',
        'logo',
        'video',
        'lang',
        'description',
        'keywords',
        'mail',
        'phone1',
        'phone2',
        'address',
        'analystic',
        'zopim',
        'facebook',
        'instagram',
        'youtube',
        'smtp_port',
        'smtp_user',
        'smtp_pass',
        'smtp_host',
        'active'
    ];
}
