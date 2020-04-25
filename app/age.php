<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class age extends Model
{
    protected $fillable = [
        'age',
    ];
    protected $primaryKey = "id_age";
}
