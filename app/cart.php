<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $fillable = [
        'date_order',
        'name_camp',
        'date_camp',
        'administration',
        'other_inforamtion',
        'id_user',
        'state'
    ];


    public function user()
    {
        return $this->belongsTo('\App\User', 'id_user', 'id');
    }

    public function game()
    {
        return $this->belongsToMany('\App\game')->withPivot('game_comment',"id_cart_game");
    }

    public function curriculum()
    {
        return $this->belongsToMany('\App\curriculum')->withPivot("id_cart_curriculum");
    }
}
