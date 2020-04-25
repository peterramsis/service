<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\curriculum;
use App\department;
use App\DataTables\curriculaDataTable;
use Intervention\Image\ImageManagerStatic as Image;
use App\attachment_curriculum;

class curriculaController extends Controller
{

    public function index(curriculaDataTable $item){
        if(Sentinel::hasAnyAccess(['admin.*'])){
            return $item->render("admin.curricula.all");
        }else{
            return redirect()->back();
        }
    }

    public function multi_Delete(){


        if(is_array(request('item')))
        {
           
            $arr = [];

            foreach(request('item') as $item){
               $curriculm =  curriculum::find($item);
               
               if($curriculm->image != ""){
                 unlink(public_path('upload/curricula/' . $curriculm->image));
               }
            }

            curriculum::destroy(request('item'));

          
        }else{
            curriculum::find(request('item'))->delete();
            
        }
    
        return redirect()->route('curricula')->with('success', 'Data has been deleted successfully');
    
    }


    public function download_attachment($attch){

        return response()->download(storage_path("app/public/upload/files/{$attch}"));
    }
    


    public function insert_curricula(Request $request){
        if(Sentinel::hasAnyAccess(['admin.*'])){

            $curriclums = department::where("dept_name","curriclums")->first();
            $dept =  department::where("parent_id",$curriclums->id)->get();
            

            if (request()->post()) 
            {
             
                $validator = \Validator::make($request->all(), [
                    'name' => 'required|min:3|max:32|unique:curricula|string',
                    'des' => 'min:3|max:32|string|required',
                    'author' => 'nullable|min:3|max:32|string',

                    'dept_id' => 'required',
                    "image" => 'required'
    
                ], [], [
                    "dept_id" => "department name",
                    "des" => "description"
                ]);


                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }
    

                

                
                Image::make($request->image)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/curricula/' . $request->image->hashName()));



                $data_sql = array(
                    "name" => $request->name,
                    "des" => $request->des,
                    "author"=>$request->author,
                    'dept_id'=>$request->dept_id,
                    'image'=> $request->image->hashName()
                );



                $curriculum = curriculum::create($data_sql);


                if($request->attachment !=""){
                    foreach($request->attachment as $item => $value){

                        if($request->attachment !=""){
                                $file = request()->file('attachment')[$item];

                                $file_name = $file->getClientOriginalName();
                                $file->storeAs('public/upload/files/', $file_name);
                            } else {
                                $file_name = "";
                            }

                        $data2 = array(
                            'attachment' =>  $file_name,
                            'curriculum_id' => $curriculum ->id
                        );

                        $item_game = attachment_curriculum::create($data2);
                    }
                }


    
                return response(["state" => "true"]);
            }
    
        
    }else{
        return redirect()->back();
    }
    }
    
    public function create()
    {

        
        if(Sentinel::hasAnyAccess(['admin.*'])){

            $curriclums = department::where("dept_name","curriclums")->first();
            $dept =  department::where("parent_id",$curriclums->id)->get();
            

            if (request()->isMethod('post')) 
            {
                $data = $this->validate(request(), [
                        'name' => 'required|min:3|max:32|unique:curricula|string',
                        'des' => 'min:3|max:32|string|required',
                        'author' => 'nullable|min:3|max:32|string',
                        'attachment' => "string|nullable",
                        'dept_id' => 'required',
                        "image" => 'required'
                ],[],[
                    "dept_id" => "department name",
                    "des" => "description"
                ]);

                

                
                Image::make(request()->image)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/curricula/' . request()->image->hashName()));



                $data_sql = array(
                    "name" => request()->name,
                    "des" => request()->des,
                    "author"=>request()->author,
                    "attachment"=>request()->attachment,
                    'dept_id'=>request()->dept_id,
                    'image'=> request()->image->hashName()
                );



                $curriculum = curriculum::create($data_sql);


    
                return redirect()->route('curricula')->with('success', 'Data has been added successfully');
            }
    
            return view('admin.curricula.add',['dept'=>$dept]);
        
    }else{
        return redirect()->back();
    }
   }


   public function update($id)
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
        $curriculum = curriculum::find($id);

        $curriclums = department::where("dept_name","curriclums")->first();
        $dept =  department::where("parent_id",$curriclums->id)->get();

        if (request()->isMethod('post'))
        {
            $data = $this->validate(request(), [
                'name' => 'required|min:3|max:32|string',
                'des' => 'min:3|max:32|string|required',
                'author' => 'nullable|min:3|max:32|string',
                
                'dept_id' => 'required',
              
        ],[],[
            "dept_id" => "department name",
            "des" => "description"
        ]);

        if (request()->image != "") {

            if ($curriculum->image != "") {
                unlink(public_path('upload/curricula/' . $curriculum->image));
            }

            Image::make(request()->image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('upload/curricula/' . request()->image->hashName()));


            $image = request()->image->hashName();
        } else {
            $image = $curriculum->image;
        }

            $curriculum->name = request()->get('name');
            $curriculum->des = request()->get('des');
            $curriculum->author = request()->get('author');
            $curriculum->dept_id = request()->get('dept_id');
            $curriculum->image =$image;

            $curriculum->save();


            if(request()->attachment !=""){
                foreach(request()->attachment as $item => $value){

                    if(request()->attachment !=""){
                            $file = request()->file('attachment')[$item];

                            $file_name = $file->getClientOriginalName();
                            $file->storeAs('public/upload/files/', $file_name);
                        } else {
                            $file_name = "";
                        }

                    $data2 = array(
                        'attachment' =>  $file_name,
                        'curriculum_id' => $curriculum ->id
                    );

                    $item_game = attachment_curriculum::create($data2);
                }
            }


            return redirect()->route('curricula')->with('success','Data has been Updated successfully');
        }

        return view('admin.curricula.update', ['curriculum' => $curriculum,'dept'=>$dept]);

       
    }else{
        return redirect()->back();
    }
    }

    public function showFile($attachment){
        return asset("app/public/upload/files/{$attachment}");
     
    }
    public function deleteFile($id){

        $att_file = attachment_curriculum::find($id);

        if($att_file !=null){
            $att_file->delete();
            return redirect()->route("curricula")->with("success","file has been deleted");
        }else{
            return redirect()->route("curricula")->with("error","file is not exist");
        }

    }
}
