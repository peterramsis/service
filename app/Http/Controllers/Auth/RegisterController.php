<?php

namespace App\Http\Controllers\Auth;

use Sentinel;
use Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\userActivation;
use Intervention\Image\ImageManagerStatic as Image;
use DB;
use App\admin;

class RegisterController extends Controller
{


    public function postRegister(Request $request)
    {

        if($request->ajax()){
            if($request->ajax()){
                $validator = \Validator::make($request->all(), [
                    'email' => 'required|unique:users,email,email',
                    'username' => 'required|min:4|max:18|alpha_dash|unique:users',
                    'password' => 'required|string|min:8|max:16|confirmed',
                    'name' => 'required|min:3|max:191|string',
                    'image' => 'required',
               ]);

                 if ($validator->fails())
                {
                    return response()->json(['errors'=>$validator->errors()->all()]);
                }
            }


            Image::make($request->file('image'))->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('upload/user/'.$request->file('image')->hashName()));

            // dd(request()->bd, request()->avatar->hashName());

            $user = Sentinel::register([
                     'email' => $request->get('email'),
                     'username' =>$request->get('username'),
                     'password' => $request->get('password'),
                     'name' =>$request->get('name'),
                     'image' => $request->file('image')->hashName(),
                 ]);

                   //create Activation code for user
                    $user = Sentinel::findById($user->id);
                    $code = Activation::create($user);
                    //send mail
                    // Mail::to($user)->send(new userActivation($user, $code));
                    // make role to users
                    $role = Sentinel::findRoleBySlug("user");
                    $role->users()->attach($user);

                    $perm[request()->role.'.'.'create'] = true;
                    $perm[request()->role.'.'.'show'] = true;
                    $perm[request()->role.'.'.'edit'] = true;
                    $perm[request()->role.'.'.'delete'] = true;
                    Admin::upgradeUser($user->id, $perm);
                    $update = DB::table('role_users')->where('user_id', $user->id)->update(['role_id' => $role->id]);

            return response(['success' =>  'Your account will be activated by the admin']);
        }else{
            return view('auth.register');

        }

    }
}
