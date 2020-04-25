<?php

namespace App\Http\Controllers;

use Sentinel;
use Activation;
use App\User;

class emailActivationController extends Controller
{
    public function activationEmail($email, $token)
    {
        if ($user = User::whereEmail($email)->first()) {
            $user = Sentinel::findById($user->id);
            if (Activation::exists($user)) {
                if (Activation::complete($user, $token)) {
                    Activation::removeExpired();
                    if (Sentinel::login($user, true)) {
                        return redirect()->home()->with('success', 'Logged in Successfully');
                    }
                }
            } else {
                return redirect()->route('login')->with('error', 'Invalid Token');
            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid Email');
        }
    }
}
