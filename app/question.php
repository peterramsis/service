<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $fillable = [
        "question_ar","question_en"
    ];
}
