<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Sentinel;
use App\DataTables\itemDataTable;
use App\item;
use App\games_item;
use App\Imports\ItemImport;

class itemController extends Controller
{
    public function index(itemDataTable $item){
        if(Sentinel::hasAnyAccess(['admin.*']))
        {
            return $item->render("admin.item.all");
        }else{
            return redirect()->back();
        }
    }

    public function download($id){

       $item = item::find($id);
       return response()->download(storage_path("app/public/upload/files/{$item->attachment}"));
    }

    public function import(){
        if (Sentinel::hasAccess('admin.create')) {


            if(request()->isMethod("post")){

              $data =  $this->validate(request(), [
                   'file' => 'required|mimes:xlsx,xls'
                ]);

                $path = request()->file;
                \Excel::import(new ItemImport, $path);
                return redirect()->route('item')->with("success","Import has been successfully");
                
            }
                  
            return view("admin.item.import");
        }else{
            return redirect()->back();
        }
    }


    public function create()
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
            if (request()->isMethod('post')) 
            {
                $data = $this->validate(request(), [
                        'item_name' => 'required|min:3|max:32|unique:items|string',
                        'description' => 'min:3|max:32|string|nullable',
                        'attachment' => 'nullable'
               ]);

               if(request()->file('attachment') != null) {

                $file = request()->file('attachment');

                $file_name = $file->getClientOriginalName();
                $file->storeAs('public/upload/files/', $file_name);
                    } else {
                        $file_name = "";
                    }



               $data_arr = array(
                'item_name' => request()->item_name,
                'description' => request()->description,
                'attachment' => $file_name
               );
    
                $item = item::create($data);
    
                return redirect()->route('item')->with('success', 'Data has been added successfully');
            }
    
            return view('admin.item.add');
        
    }else{
        return redirect()->back();
    }
   }


   public function multi_Delete(){


    if(is_array(request('item')))
    {
        item::destroy(request('item'));
    }else{
        item::find(request('item'))->delete();
    }

    return redirect()->route('item')->with('success', 'Data has been deleted successfully');

}


public function update($id)
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
        $item = item::find($id);

        if (request()->isMethod('post'))
        {
            $data = $this->validate(request(), [
                'item_name' => 'required|min:3|max:32|string',
                'description' => 'min:3|max:32|string|nullable',
               
           ]);

            $item->item_name = request()->get('item_name');
            $item->description = request()->get('description');

            if(request()->attachment != ""){
                if($item->attachment !=""){
                
                        
                    if(file_exists('public/upload/files/'.$item->attachment)){
                        unlink('public/upload/files/'.$item->attachment);
                    }

                    $file = request()->attachment;

                    $file_name = $file->getClientOriginalName();
                    
                    $file->storeAs('public/upload/files/', $file_name);
                    $item->attachment = $file_name;

                   
               }else{
                $file =  request()->attachment;

               

                $file_name = $file->getClientOriginalName();
                $file->storeAs('public/upload/files/', $file_name);
                   
                $item->attachment = $file_name;

               }
            }
            $item->save();

            return redirect()->route('item')->with('success', 'Data has been Updated successfully');
        }

        return view('admin.item.update', ['item' => $item]);

       
    }else{
        return redirect()->back();
    }
}
}
