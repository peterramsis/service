<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class game extends Model
{

    protected $fillable = [
        'game_name',
        'img_main',
        'description',
        'material' ,
        'images',
        'video',
        'dept_id',
        'rules',
        'attachment',
        'number_of_player',
        'age'
    ];


    public function department()
    {
        return $this->belongsTo('\App\department', 'dept_id', 'id');
    }

 
    public function number_of_player_game()
    {
        return $this->belongsTo('\App\numberOfPlayer', 'number_of_player', 'id_number');
    }

    public function tag()
    {
        return $this->belongsToMany('\App\tag','game_tag');
    }
    public function age()
    {
        return $this->belongsToMany('\App\age','gameAge');
    }
    public function item()
    {
        return $this->belongsToMany('\App\item')->withPivot('qty','id');
    }
    public function images()
    {
        return $this->hasMany('\App\images_game');
    }

    public function attach()
    {
        return $this->hasMany('\App\attathcment_game');
    }

}
