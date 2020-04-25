<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Resources\game as GameResources;

Route::group(['middleware' => 'auth:api',"namespace"=> 'api'], function () {

   Route::get("games",function(request $request){
      

      return response(["games"=> new GameResources(App\game::all())]);
   });
    
});


Route::group(['namespace' => 'api'], function () {
    Route::post("login","userLoginControl@login");
    Route::post("register","userRegisterControl@postRegister");
    
});



Route::get("users",function(){
  
    return response(["status","users"=>App\User::all()]);

});
