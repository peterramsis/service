<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class game_tag extends Model
{
    //
    protected $fillable = [
        'game_id',
        'tag_id'
    ];

}
