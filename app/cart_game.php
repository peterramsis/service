<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart_game extends Model
{

    protected $table = "cart_game";
    protected $primaryKey = "id_cart_game";
    
    protected $fillable = [
        'game_id',
        'cart_id',
        'game_comment'
    ];
}
