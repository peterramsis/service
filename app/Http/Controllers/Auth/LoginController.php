<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;

class LoginController extends Controller
{
    public function getLogin()
    {
        if ($user = Sentinel::check()) {
            return redirect()->back();
        } else {
            return view('auth.login');
        }
    }

    public function postLogin(Request $request)
    {


        if($request->ajax()){


            $validator = \Validator::make($request->all(), [
                'email' => new \App\Rules\usernameOrPassword(),
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

                        if ($u->hasAnyAccess(['admin.*'])) {
                            return response(["data"=>"admin"]);
                        } elseif ($u->hasAccess('user.*')) {
                            return response(["data"=>"user"]);
                        }
                    }

                    return response(['errors' => 'Username or Password Invalid']);
                } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
                    return response(['errors' => 'Your account will be activated by the admin']);
                }
        }

    }

    public function logout()
    {
        Sentinel::logout(null, true);

        return redirect()->route('/')->with('success', 'Come back again whatever you can');
    }
}
