<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dept_camp;
use Sentinel;

class deptcampsController extends Controller
{
    public function index()
    {
        if (Sentinel::hasAccess('admin.create')) {
        $department = dept_camp::orderBy('id', 'desc')->paginate(5);

        return view('admin.dept.master', ['department' => $department]);

        }else{
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        if (Sentinel::hasAccess('admin.create')) {
            if ($request->isMethod('get')) {
                $department = dept_camp::where('department_name', 'like', '%'.$request->get('search').'%')->paginate(5);

                $this->validate(request(), [
                    'search' => 'sometimes|required|string|max:60',
                ]);

                if ($department->count() == 0) {
                    return redirect()->route('dept_camp')->with('error', 'Data is not found');
                } else {
                    return view('admin.dept.search', ['department' => $department]);
                }
            }
       }else{
        return redirect()->back();
       }

    }



    public function create()
    {
        if (Sentinel::hasAccess('admin.create')) {
            if (request()->isMethod('post'))
            {
                    $data = $this->validate(request(), [
                            'department_name' => 'required|min:4|max:20|unique:dept_camps|string',
                    ]);


                    dept_camp::create($data);

                    return redirect()->route('dept_camp')->with('success', 'Data Added');
                }

                return view('admin.dept.add');
            }else{
                return redirect()->back();

            }

    }

    public function update($id)
    {
        if (Sentinel::hasAccess('admin.create')) {
        $department = dept_camp::find($id);

        if (request()->isMethod('post')) {
            $data = $this->validate(request(), [
                    'department_name' => 'required|min:4|max:20|string',
           ]);

            $department->department_name = request()->get('department_name');

            $department->save();

            return redirect()->route('dept_camp')->with('success', 'Data Update');
        }

        return view('admin.dept.update', ['department' => $department]);
    }else{
        return redirect()->back();
    }

    }



    public function delete($id)
    {

        if (Sentinel::hasAccess('admin.create')) {
        $department = dept_camp::find($id);



            if ($department != null) {
                $department->delete();

                return redirect()->route('dept_camp')->with('success', 'Data deleted');
            } else {
                return redirect()->route('dept_camp')->with('error', 'error database');
            }

        }else{
            return redirect()->back();
        }
    }
}
