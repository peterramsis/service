<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class camp extends Model
{
    protected $fillable = [
        'camp_name',
        'date_from',
        'date_to',
        'dept_id'
    ];

    public function dept()
    {
        return $this->belongsTo('\App\dept_camp', 'dept_id', 'id');
    }
}
