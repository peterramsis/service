<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\DataTables\ageDataTable;
use App\age;

class ageControll extends Controller
{
    public function index(ageDataTable $item)
    {
        if (Sentinel::hasAnyAccess(['admin.*'])) {
            return $item->render("admin.age.all");
        } else {
            return redirect()->back();
        }
    }


    public function multi_Delete(){


        if(is_array(request('item')))
        {
            age::destroy(request('item'));
        }else{
            age::find(request('item'))->delete();
        }
    
        return redirect()->route('age')->with('success', 'Data has been deleted successfully');
    
    }

    public function create()
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
            if (request()->isMethod('post')) 
            {
                $data = $this->validate(request(), [
                        'age' => 'required|min:3|max:32|unique:ages|string',
                        
               ]);
    
                $item = age::create($data);
    
                return redirect()->route('age')->with('success', 'Data has been added successfully');
            }
    
            return view('admin.age.add');
        
    }else{
        return redirect()->back();
    }
   }

   public function update($id)
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
        $age = age::find($id);

        if (request()->isMethod('post'))
        {
            $data = $this->validate(request(), [
                'age' => 'required|min:3|max:32|string',
           ]);

            $age->age = request()->get('age');

            $age->save();

            return redirect()->route('age')->with('success', 'Data has been Updated successfully');
        }

        return view('admin.age.update', ['age' => $age]);

       
    }else{
        return redirect()->back();
    }
}
}
