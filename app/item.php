<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $fillable = [
        'item_name',
        'description',
        'attachment'
    ];
}
