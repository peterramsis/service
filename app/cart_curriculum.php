<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart_curriculum extends Model
{
    protected $table = "cart_curriculum";
    protected $primaryKey = "id_cart_curriculum";
    protected $fillable = [
        'curriculum_id',
        'cart_id',
    ];
}
