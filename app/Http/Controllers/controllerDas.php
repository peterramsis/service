<?php

namespace App\Http\Controllers;

use Sentinel;
use App\User;


class controllerDas extends Controller
{
    public function index()
    {
        if(Sentinel::hasAnyAccess(["admin.*"])){
            $user = User::all();
            return view("admin.dashboard",[
                'users' => $user->count()
            ]);
        }else{
            return redirect()->back();
        }
    }


}
