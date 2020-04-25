<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class games_item extends Model
{
    protected $fillable = [
        'game_id',
        'item_id',
        'qty'
    ];
    protected $table = "game_item";

}
