<?php

namespace App\Http\Controllers;

use Sentinel;
use App\User;
use App\question;


class controllerDas extends Controller
{
    public function index()
    {
        if(Sentinel::hasAnyAccess(["admin.*"])){
            $user = User::all();
            $question = question::all();
            return view("admin.dashboard",[
                'users' => $user->count(),
                "question"=> $question->count(),
            ]);
        }else{
            return redirect()->back();
        }
    }


}
