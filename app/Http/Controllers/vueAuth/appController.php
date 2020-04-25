<?php

namespace App\Http\Controllers\vueAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class appController extends Controller
{
    
   public function register(Request $request){

    $validator = \Validator::make($request->all(), [
        'email' => 'required|unique:users,email,email',
        'username' => 'required|min:4|max:18|alpha_dash|unique:users',
        'password' => 'required|string|min:8|max:16|confirmed',
        'last_name' => 'required|min:3|max:18|alpha',
        'first_name' => 'required|min:3|max:18|alpha',
        'birthday' => 'required|date',
        'image' => 'required',
     ]);

     if ($validator->fails())
     {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }


     Image::make(request()->get('image'))->resize(800, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save(public_path('upload/user/'.request()->get('image')->hashName()));

    $user = Sentinel::register([
        'email' => request()->get('email'),
        'username' => request()->get('username'),
        'password' => request()->get('password'),
        'last_name' => request()->get('last_name'),
        'first_name' => request()->get('first_name'),
        'birthday' => request()->get('birthday'),
        'image' => request()->get('image')->hashName(),
    ]);

    //create Activation code for user
    $user = Sentinel::findById($user->id);
    $code = Activation::create($user);
    //send mail
    Mail::to($user)->send(new userActivation($user, $code));
    // make role to users
    $role = Sentinel::findRoleBySlug('user');
    $role->users()->attach($user);



    return response(["status"=> true, "user" => $user]);

   }


   public function login(Request $request){

    $validator = \Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required|min:6|max:32',
        'remember' => 'in:on,null',
     ]);

     

     if ($validator->fails())
     {
         return response()->json(['errors'=>$validator->errors()->all()]);
     }
  
    $remember = false;

    try {
        if (request('remember') === 'on') {
            $remember = true;
        }

        $user = Sentinel::authenticate([
        'login' => request('email'),
        'password' => request('password'),
      ]);

        if ($user) {
            $u = \App\User::whereUsernameOrEmail(request('email'), request('email'))->first();
            $u = Sentinel::findById($u->id);

            $u = Sentinel::login($u, $remember);

            if ($u->hasAnyAccess(['admin.*', 'editor.*'])) {
                return redirect()->route('admin')->with('success', 'You are in admin panel');
            } elseif ($u->hasAccess('user.*')) {
                return redirect()->route('home')->with('success', 'You are loggin');
            }
        }

        return redirect()->back()->with('error', 'Username or Password Invalid');
    } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
        return redirect()->home()->with('error', 'please check your email address for activated your Account');
    }
   }

}
