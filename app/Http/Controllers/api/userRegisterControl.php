<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use Intervention\Image\ImageManagerStatic as Image;
use Mail;
use App\Mail\userActivation;
use Activation;

class userRegisterControl extends Controller
{
    public function postRegister(Request $request)
    {

   
       $imageData = $request->file('image');
       //$fileName =   uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
      
       return response(["status"=> $imageData]);
    }
}
