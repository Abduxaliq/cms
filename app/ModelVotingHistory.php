<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelVotingHistory extends Model
{
    protected $table = "voting_history";

    protected $fillable = [
        'address', 'voting_id'
    ];
}
