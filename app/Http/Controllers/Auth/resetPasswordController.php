<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Sentinel;
use Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class resetPasswordController extends Controller
{
    public function resetPasswordThroughEmail($email, $token)
    {
        $user = User::whereEmail($email)->first();



        if ($user) {
            $user = Sentinel::findById($user->id);
            if (Reminder::exists($user)) {
                if (Reminder::exists($user)->code === $token) {
                    \Session::put('user', $user);
                    \Session::put('token', $token);

                    return view('auth.pass.reset');
                } else {
                    return redirect()->route('/')->with('error', 'Invalid Token');
                }
            } else {
                return redirect()->route('/')->with('error', 'Invalid Token');
            }
        } else {
            return redirect()->route('/')->with('error', 'Email Does not exist');
        }
    }

    public function postResetPassword()
    {

        request()->validate([
            'password' => 'required|min:8|max:32|confirmed',
        ]);
        //dd(\Session::get('email'), \Session::get('token'), request('password'));


        if ($reminder = Reminder::complete(\Session::get('user'), \Session::get('token'), request('password'))) {
            Reminder::removeExpired();
            \Session::flush();

            return redirect()->route('/')->with('success', 'Password Has Been changed Successfully');
        } else {
            return redirect()->route('/')->with('error', 'Please Try again later');
        }
    }
}
