<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class numberOfPlayer extends Model
{
    protected $fillable = [
        'number_of_player',
    ];

    protected $primaryKey = "id_number";
}
