<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    protected $fillable = [
        "meta_keywords_ar",
        "meta_keywords_en",
        "meta_description_ar",
        "meta_description_en",
        "about_us_en",
        "about_us_ar"
    ];
}
