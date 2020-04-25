<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\numberOfPlayer;
use App\DataTables\numberOfPlayerDataTable;

class numberOfPlayerControll extends Controller
{

    public function index(numberOfPlayerDataTable $number){
        if(Sentinel::hasAnyAccess(['admin.*']))
        {
            return $number->render("admin.number.all");
        }else{
            return redirect()->back();
        }
    }

    public function multi_Delete(){


        if(is_array(request('item')))
        {
            numberOfPlayer::destroy(request('item'));
        }else{
            numberOfPlayer::find(request('item'))->delete();
        }
    
        return redirect()->route('number')->with('success', 'Data has been deleted successfully');
    
    }


    public function create()
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
            if (request()->isMethod('post')) 
            {
                $data = $this->validate(request(), [
                        'number_of_player' => 'required|min:3|unique:number_of_players|string',
               ]);
    
                $numberOfPlayer = numberOfPlayer::create($data);
    
                return redirect()->route('number')->with('success', 'Data has been added successfully');
            }
    
            return view('admin.number.add');
        
    }else{
        return redirect()->back();
    }
   }

   public function update($id)
    {
        if(Sentinel::hasAnyAccess(['admin.*'])){
        $number = numberOfPlayer::find($id);

        if (request()->isMethod('post'))
        {
            $data = $this->validate(request(), [
                'number_of_player' => 'required|min:3|string',
               
           ]);

            $number->number_of_player = request()->get('number_of_player');
            $number->save();

            return redirect()->route('number')->with('success', 'Data has been Updated successfully');
        }

        return view('admin.number.update', ['number' => $number]);

       
    }else{
        return redirect()->back();
    }
}
}
