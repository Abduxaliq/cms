<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelPosts extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'category',
        'title',
        'short_title',
        'description',
        'content',
        'author',
        'date',
        'tags',
        'image',
        'active',
        'slug',
        'views'
    ];

    public function category_data()
    {
        return $this->belongsTo('App\ModelCategory', 'category', 'id');
    }

    public function position_data()
    {
        return $this->belongsToMany(
            'App\ModelPosition',
            'post_position',
            'posts_id',
            'position_id'
        );
    }
}
