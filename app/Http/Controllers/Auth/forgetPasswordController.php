<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Sentinel;
use Activation;
use Reminder;
use Mail;

class forgetPasswordController extends Controller
{
    public function resetPass()
    {

        if (request()->post()) {
            request()->validate([
                'email' => 'required|string',
            ]);

            $user = User::whereUsernameOrEmail(request('email'), request('email'))->first();

            if ($user != null) {
                $user = Sentinel::findById($user->id);
                if (Activation::completed($user)) {
                    $reminder = Reminder::exists($user) ?: Reminder::create($user);
                    $this->sendEmail($user, $reminder->code);

                    return redirect()->route('/')->with('success', 'Reset code Has been send to your account');
                } else {
                    return redirect()->route('/')->with('error', 'Activation your account first');
                }
            } else {
                return redirect()->route('login')->with('error', 'The email address is not registered');
            }
        }
    }

    public function sendEmail($user, $token)
    {
        Mail::send('email.reset', ['user' => $user, 'token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Your Password');
        });
    }
}
