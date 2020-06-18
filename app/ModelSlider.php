<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelSlider extends Model
{
    protected $table='slider';
    protected $fillable=['posts_id','image','url','slug','active'];

    public function slider_post(){
        return $this->belongsTo('App\ModelPosts', 'posts_id', 'id');
    }
}
