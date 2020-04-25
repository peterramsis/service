<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class curriculum extends Model
{
    protected $fillable = [
        'name',
        'des',
        'attachment',
        'author',
        'dept_id',
        'image'
    ];
    public function department()
    {
        return $this->belongsTo('\App\department', 'dept_id', 'id');
    }

    public function attach()
    {
        return $this->hasMany('\App\attachment_curriculum');
    }
}
