<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use User;
use Validator;
use Auth;
use Sentinel;

class userLoginControl extends Controller
{
    public function login(Request $request){
     
        $rule = [
            "email"=>"required",
            "password"=>"required",
            'remember' => 'in:on,null',
        ];
      
     $this->validate($request,$rule);

        

    $remember = false;

    try {
        if ($request->get('remember') === 'on') {
            $remember = true;
        }

        $user = Sentinel::authenticate([
        'login' =>$request->get("email"),
        'password' => $request->get('password'),
      ]);

        if ($user) {
            $u = \App\User::whereUsernameOrEmail($request->get('email'), $request->get('email'))->first();
            $u = Sentinel::findById($u->id);

            $u = Sentinel::login($u, $remember);
            
            return response(['status'=>true,"user"=>$u,"api_token"=>$u->api_token]);
            
        }

        return response(['status'=>false,'errors'=> 'Username or Password Invalid']);
    } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
    
        return response(['status'=>false,'errors'=> 'please check your email address for activated your account']);
    }


    }
}
