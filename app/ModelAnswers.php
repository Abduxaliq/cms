<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelAnswers extends Model
{
    protected $table = "answers";

    protected $fillable = ['question_id', 'text', 'vote_count'];
}
