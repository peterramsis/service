<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Sentinel;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;
use App\Admin;


class usersController extends Controller
{
    public function index()
    {
        if (Sentinel::hasAccess('admin.*')) {
            $users = Sentinel::getUser()->orderBy('id', 'desc')->paginate(10);

            return view('admin.users.user', ['users' => $users]);
        } else {
            return redirect()->back();
        }
    }

    public function add_user()
    {
        if (Sentinel::hasAccess('admin.*')) {
            if (request()->isMethod('post')) {


                request()->validate([
                    'email' => 'required|unique:users,email,email',
                    'username' => 'required|min:4|max:18|alpha_dash|unique:users',
                    'password' => 'required|string|min:8|max:16|confirmed',
                    'name' => 'required|min:3|string',
                    'birthday' => 'required|date',
                    'image' => 'required',
                    "mobile"=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    "instagram"=>"url",
                    "twitter"=>'url',
                    "facebook"=>'required|url',
                    "religion"=>"required|string",
                    "sect"=>"required|string",
                    "church"=>"required|string"

                ]);
                Image::make(request()->image)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/user/'.request()->image->hashName()));

                // dd(request()->bd, request()->avatar->hashName());

                $user = Sentinel::registerAndActivate([
                 'email' => request()->email,
                 'username' => request()->username,
                 'password' => request()->password,
                 'name' => request()->name,
                 'birthday' => request()->birthday,
                 'image' => request()->image->hashName(),
                 "phone"=>request()->phone,
                 "mobile"=>request()->mobile,

                 "twitter"=>request()->twitter,
                 "facebook"=>request()->facebook,
                 "instagram"=>request()->instagram,

                 "religion"=>request()->religion,
                 "sect"=>request()->sect,
                 "church"=>request()->church,
                ]);

                $role = Sentinel::findRoleBySlug('user');
                $role->users()->attach($user);


                if(app()->getlocale() == "ar"){
                    return redirect()->route('mangeUsers')->with('success', 'تم الاضافة بنجاح');
                }else{
                    return redirect()->route('mangeUsers')->with('success', "Data has been added successfully");

                }

            }




            return view('admin.users.add_user');
        } else {
            return redirect()->back();
        }
    }

    public function addRole()
    {
        if (Sentinel::hasAccess('admin.*')) {
            if (request()->isMethod('post')) {
                $data = $this->validate(request(), [
                'name' => 'required|min:2|max:32|string',
                'slug' => 'required|min:2|max:190',
                ]);

                $perm = [];

                $perm[request()->slug.'.'.'create'] = true;
                $perm[request()->slug.'.'.'show'] = true;
                $perm[request()->slug.'.'.'edit'] = true;
                $perm[request()->slug.'.'.'delete'] = true;

                $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => ucfirst(request()->name),
            'slug' => request()->slug,
            'permissions' => $perm,
        ]);



                if(app()->getlocale() == "ar"){
                    return redirect()->route('mangeUsers')->with('success', 'تم  الاضافة بنجاح');
                }else{
                    return redirect()->route('mangeUsers')->with('success', "Data has been delete successfully");

                }
            }

            return view('admin.users.add_role');
        } else {
            return redirect()->back();
        }
    }

    public function updateRole($id)
    {
        $role = DB::table('roles')->where('id', $id)->first();

        dd($role);
    }

    public function all_role()
    {
        if (Sentinel::hasAccess('admin.*')) {
            $all = Sentinel::getRoleRepository()->all();

            return view('admin.users.roles', ['roles' => $all]);
        } else {
            return redirect()->back();
        }
    }

    public function delete_role($id)
    {
        $role = Sentinel::findRoleById($id)->delete();


        if(app()->getlocale() == "ar"){
            return redirect()->route('mangeUsers')->with('success', 'تم المسح بنجاح');
        }else{
            return redirect()->route('mangeUsers')->with('success', "Data has been delete successfully");

        }
    }

    public function update_role($id)
    {
        $role = DB::table('roles')->where('id', $id)->first();

        if (Sentinel::hasAccess('admin.*')) {
            if (request()->isMethod('post')) {
                $data = $this->validate(request(), [
                'name' => 'required|min:2|max:32|string',
                'slug' => 'required|min:2|max:190',
                ]);

                $perm = [];

                $perm[request()->slug.'.'.'create'] = true;
                $perm[request()->slug.'.'.'show'] = true;
                $perm[request()->slug.'.'.'edit'] = true;
                $perm[request()->slug.'.'.'delete'] = true;

                $arrr = [];

                //dd(implode(',', array_($perm)));

                //DB::table('roles')->where('id', $id)->update(['name' => request()->name, 'slug' => request()->slug, 'permissions' => $perm]);

                //return redirect()->route('allRole')->with('success', 'Add Role');
            }
        }

        return view('admin.users.update_role', ['role' => $role]);
    }

    public function make_all_read()
    {
        $id = Sentinel::getUser()->id;
        $user = User::find($id);

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }

    public function make_id_read(Request $req)
    {
        $id = $req->get('id');
        $up = DB::table('notifications')
            ->where('id', $id)
            ->update(['read_at' => now()]);

        if ($up) {
            return response()->json(['state' => 'true']);
        } else {
            return response()->json(['error' => 'false']);
        }
    }

    public function Update($id)
    {
        $roles = DB::table('roles')->get();
        $users = User::find($id);

        if (request()->isMethod('post')) {
            $id_role = DB::table('role_users')->where('user_id', $id)->first();


            $users->save();
            if ($id_role == null) {
                $user = Sentinel::findById($id);
                $role = Sentinel::findRoleBySlug(request()->role);
                $role->users()->attach($user);
            } else {
                DB::table('users')->where('id', $users->id)->update(['permissions' => '']);
                $perm[request()->role.'.'.'create'] = true;
                $perm[request()->role.'.'.'show'] = true;
                $perm[request()->role.'.'.'edit'] = true;
                $perm[request()->role.'.'.'delete'] = true;
                $role = Sentinel::findRoleBySlug(request()->role);
                Admin::upgradeUser($id, $perm);
                $update = DB::table('role_users')->where('user_id', $id)->update(['role_id' => $role->id]);
            }

            if(app()->getlocale() == "ar"){
                return redirect()->route('mangeUsers')->with('success', 'تم التعديل بنجاح');
            }else{
                return redirect()->route('mangeUsers')->with('success', "Data has been update successfully");
            }
        }





        return view('admin.users.user1', ['user' => $users, 'roles' => $roles]);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if ($user != null) {
            $user->delete();

            if(app()->getlocale() == "ar"){
                return redirect()->route('mangeUsers')->with('success', 'تم المسح بنجاح');
            }else{
                return redirect()->route('mangeUsers')->with('success', "Data has been delete successfully");

            }
        } else {
            dd('error');
        }
    }

    public function search(Request $request)
    {
        $this->validate(request(), [
            'search' => 'sometimes|required|string|max:60|min:3',
        ]);
        $serach =$request->search;



        $user = Sentinel::getUser()->Where("username",'LIKE', "%$serach%")->orWhere("name",'LIKE', "%$serach%")->orWhere("email",$serach)->paginate(10)->setPath('');

        $user = $user->appends ( array (
            'search' => $request->get('search')
          ));
        if($user->count() > 0){
           return view("admin.users.search",["users" => $user])->withData($user);
        }else{

            if(app()->getlocale() == "ar"){
                return redirect()->route('mangeUsers')->with('error', 'لايوجد مستخدم بهذه البيانات');
            }else{
                return redirect()->route('mangeUsers')->with('error', 'this is not found');

            }

        }

    }

    public function updateProfile($id)
    {
        $user = User::find($id);
        if (request()->isMethod('post')) {
            $data = $this->validate(request(), [
                'first_name' => 'required|min:3|max:32|string',
                'last_name' => 'required|min:3|max:190',
                'birthday' => 'required|date',
                ]);

            $v = Validator::make($data, [
                'image' => 'mimes:jpeg,bmp,png|required',
            ]);

            if (request()->image) {
                if (request()->get('image') != 'user.png') {
                    \Storage::disk('public_upload')->delete('user/'.$user->image);
                }
            }

            if (request()->image != '') {
                Image::make(request()->image)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/user/'.request()->image->hashName()));
                $user->image = request()->image->hashName();
            }

            $user->first_name = request()->first_name;
            $user->last_name = request()->last_name;
            $user->birthday = request()->birthday;
            $user->save();
            if ($user) {
                return redirect()->route('changeProfile', $user->id)->with('success', 'Update Profile');
            } else {
                return redirect()->route('changeProfile', $user->id)->with('error', 'Unupdate Profile');
            }
        }

        return view('admin.users.profile');
    }
}
