<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gameAge extends Model
{
    protected $fillable = [
        'game_id',
        'age_id'
    ];
    protected $table = "gameage";
}
