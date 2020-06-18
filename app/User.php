<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "users";
    protected $fillable = ['fullname', 'email', 'password', 'activation_key', 'active', 'permission'];
    protected $hidden = ['password', 'activation_key'];
}
