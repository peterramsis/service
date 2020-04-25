<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Auth'], function () {
    Route::group(['middleware' => 'guest'], function () {

        Route::match(['get', 'post'],"register" ,'RegisterController@postRegister')->name("register");
        Route::post('/login', [
                'uses' => 'LoginController@postLogin',
                'as' => 'login',
            ]);
        Route::get('/', [
                'uses' => 'LoginController@getLogin',
                'as' => '/',
            ]);
        Route::view('/password/forget', 'auth.pass.forget')->name('forget');
        Route::post('/password/forget', 'forgetPasswordController@resetPass')->name('forget');
        Route::get('/reset/{email}/{token}', 'resetPasswordController@resetPasswordThroughEmail')->name('reset-password');
        Route::post('/reset/password', 'resetPasswordController@postResetPassword')->name('reset');
    });

    Route::post('/logout', [
        'uses' => 'LoginController@logout',
        'as' => 'logout',
     ]);


});



    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get("get_camp","controllerDas@get_camp")->name("get_camp");
        Route::get('/', 'controllerDas@index')->name('admin')->middleware('admin');
        Route::match(['get', 'post'], 'change/{id}', 'usersController@updateProfile')->name('changeProfile');

        Route::get('users', 'usersController@index')->name('mangeUsers');
        Route::match(['get', 'post'], 'users/addUser', 'usersController@add_user')->name('addUser');
        Route::get('users/delete_user/{id}', 'usersController@delete')->name('deleteUsers');
        Route::match(['get', 'post'], 'update/{id}', 'usersController@Update')->name('userUpdate');
        Route::get('delete/{id}', 'usersController@delete');
        Route::match(['get', 'post'], 'roles', 'usersController@addRole')->name('add_role');
        Route::get('allRole', 'usersController@all_role')->name('allRole');
        Route::match(['get', 'post'], 'update_role/{id}', 'usersController@update_role')->name('updateRole');
        Route::get('delete_role/{id}', 'usersController@delete_role')->name('deleteRole');


    });



Route::get('/activation/{email}/{token}', 'emailActivationController@activationEmail');



Route::get('/role', function () {
    $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'user',
            'slug' => 'user',
            'permissions' => [
                'user.create' => true,
                'user.show' => true,
                'user.edit' => true,
                'user.approve' => true,
                'user.delete' => true,
                ],
        ]);
});

Route::get("home",function(){


#dd(app()->getLocale());
 return view("home");
})->name("home");


Route::get("changeLan/{lan}","changeLan@change")->name("changeLan");





