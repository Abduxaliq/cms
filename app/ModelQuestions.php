<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelQuestions extends Model
{
    protected $table = "questions";

    protected $fillable = ['text', 'active'];

    public function answers_data() {
        return $this->hasMany('App\ModelAnswers', 'question_id');
    }
}
