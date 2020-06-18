<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelMenus extends Model
{
    protected $table='menus';
    protected $fillable=[
        'parent_id',
        'name',
        'slug',
        'active',
        'rank',
        'type',
        'foreign_key'
    ];

    public function parent() {
        return $this->belongsTo('App\ModelMenus', 'parent_id');
    }

    public function page() {
        return $this->belongsTo('App\ModelPage', 'foreign_key', 'id');
    }

    public function category() {
        return $this->belongsTo('App\ModelCategory', 'foreign_key', 'id');
    }
}
