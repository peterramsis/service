<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\department;
use Sentinel;
use Intervention\Image\ImageManagerStatic as Image;


class departmentController extends Controller
{
   public function index(){
    if (Sentinel::hasAccess('admin.create')) {

    $dept = department::all();

    return view("admin.department.all");

   }else{
        return rediect()->back();
    }

   }

   public function delete(Request $request){

    if (Sentinel::hasAccess('admin.create')) {
        $value = $request->get('id');

        $dept = department::find($value);
        $dept->delete();
        return response()->json(['state' => 'delete']);

    }else{
        return rediect()->back();
    }

   }

   public function create(){

    if (Sentinel::hasAccess('admin.create')) {

        if (request()->isMethod('post')) {

           $data=  $this->validate(request(), [
                'dept_name' => 'required|string|min:3|max:190',
                'parent_id' => 'sometimes|nullable|numeric',
                'description' =>'sometimes|nullable',
                'icon' => 'required',
                'keyword' => 'sometimes|nullable'
            ]);

            Image::make(request()->icon)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('upload/dept/' . request()->icon->hashName()));


            $data_dept = array(
                'dept_name' => request()->dept_name,
                'parent_id' => request()->parent_id,
                'description' => request()->description,
                'icon' => request()->icon->hashName(),
                'keyword' => request()->keyword,
            );

           $dept =  department::create($data_dept);


            $count = department::where("parent_id",request()->parent_id)->count();
           
           
            if(isset($count)){
                if($count >0){
                    $dept_sub = department::find(request()->parent_id);
                    if($dept_sub != null){
                        $dept_sub->is_sup = 1;
                        $dept_sub->save();
                    }
                   
                   }
                
            }



            return redirect()->route("department")->with("success","Data Added");

        }

        return view("admin.department.add");


    }else{
        return redirect()->back();
    }
   }


   public function update($id){



    $dept = department::find($id);

    if (Sentinel::hasAccess('admin.create')) {

        if (request()->isMethod('post')) {

           $data=  $this->validate(request(), [
                'dept_name' => 'required|string|min:3|max:190',
                'parent_id' => 'sometimes|nullable|numeric',
                'description' =>'sometimes|nullable',
                'icon' => 'sometimes|nullable',
                'keyword' => 'sometimes|nullable'
            ]);

            if (request()->icon != "") {

                if ($dept->icon != "") {
                    unlink(public_path('upload/dept/' . $dept->icon));
                }

                Image::make(request()->img_main)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/dept/' . request()->icon->hashName()));


                $icon = request()->icon->hashName();

            } else {
                $icon = $dept->icon;
            }

            $dept->dept_name = request()->dept_name;
            $dept->parent_id = request()->parent_id;
            $dept->description = request()->description;
            $dept->icon =$icon;
            $dept->keyword = request()->keyword;
            $dept->save();

            $count = department::where("parent_id",request()->parent_id)->count();


            return redirect()->route("department")->with("success","Data Update");
        }

        return view("admin.department.update",["dept"=>$dept]);


    }else{
        return redirect()->back();
    }



   }
}
