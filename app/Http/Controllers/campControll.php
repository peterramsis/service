<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\camp;
use App\dept_camp;
use Sentinel;

class campControll extends Controller
{
    public function index(){

        if (Sentinel::hasAccess('admin.create'))
        {
           $camp = camp::orderBy('id', 'desc')->paginate(5);
           return view('admin.camp.all', ['camp' => $camp]);
        }else{
            return redirect()->back();
        }

    }

    public function create(){
        if (Sentinel::hasAccess('admin.create')) {

            $dept =dept_camp::all();
            if (request()->isMethod('post'))
            {
                    $data = $this->validate(request(), [
                            'camp_name' => 'required|min:4|max:20|unique:camps|string',
                            'date_from' => 'required|date',
                            'date_to' => 'required|date',
                            'dept_id' => 'required'
                    ]);
                    camp::create($data);
                    return redirect()->route('camp')->with('success', 'Data Added');
            }
                return view('admin.camp.add',['dept'=>$dept]);
        }else{
            return redirect()->back();

        }
    }


    public function update($id)
    {

        if (Sentinel::hasAccess('admin.create')) {
        $camp = camp::find($id);
        $dept =dept_camp::all();

        if (request()->isMethod('post')) {
            $data = $this->validate(request(), [
                'camp_name' => 'required|min:4|max:20|string',
                'date_from' => 'required|date',
                'date_to' => 'required|date',
                'dept_id' => 'required'
        ]);

            $camp->camp_name = request()->get('camp_name');
            $camp->date_from = request()->get('date_from');
            $camp->date_to = request()->get('date_to');
            $camp->dept_id = request()->get('dept_id');
            $camp->save();
            return redirect()->route('camp')->with('success', 'Data Update');
        }

        return view('admin.camp.update', ['camp' => $camp,'dept'=>$dept]);
    }else{
        return redirect()->back();
    }

    }



    public function search(Request $request)
    {
        if (Sentinel::hasAccess('admin.create')) {
            if ($request->isMethod('get')) {
                $camp = camp::where('camp_name', 'like', '%'.$request->get('search').'%')->paginate(5);

                $this->validate(request(), [
                    'search' => 'sometimes|required|string|max:60',
                ]);

                if ($camp->count() == 0) {
                    return redirect()->route('camp')->with('error', 'Data is not found');
                } else {
                    return view('admin.camp.search', ['camp' => $camp]);
                }
            }
       }else{
        return redirect()->back();
       }

    }



    public function delete($id){

        if (Sentinel::hasAccess('admin.create')) {
            $camp = camp::find($id);
                if ($camp != null)
                {
                    $camp->delete();
                    return redirect()->route('camp')->with('success', 'Data deleted');
                } else {
                    return redirect()->route('camp')->with('error', 'error database');
                }
            }else{
                return redirect()->back();
            }

    }
}
