<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\department;

class testUi extends Controller
{
  public function cats(){
    $dept = department::all();

    return view("cats",["dept"=>$dept]);

  }

  
}
