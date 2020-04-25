<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class changeLan extends Controller
{
    public function change($lan){

        \Session::put("lan",$lan);
       return redirect()->back();

    }
}
