<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $fillable = [
        'dept_name', 'icon', 'keyword','description','parent_id',"is_sup"
    ];


    public function parents(){
        return $this->hasMany("App\Model\department",'id',"parent");
    }
}
