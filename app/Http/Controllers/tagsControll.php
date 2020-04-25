<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\tag;

class tagsControll extends Controller
{
    public function index(){

        if (Sentinel::hasAccess('admin.create'))
        {
           $tags = tag::orderBy('id', 'desc')->paginate(5);
           return view('admin.tags.master', ['tags' => $tags]);
        }else{
            return redirect()->back();
        }
    }

    public function create(){
        if (Sentinel::hasAccess('admin.create')) {
            if (request()->isMethod('post'))
            {
                    $data = $this->validate(request(), [
                            'tag_name' => 'required|min:2|max:100|unique:tags|string',
                    ]);
                    tag::create($data);
                    return redirect()->route('tags')->with('success', 'Data Added');
            }
                return view('admin.tags.add');
        }else{
            return redirect()->back();
        }
    }


    public function update($id){
        if (Sentinel::hasAccess('admin.create')) {
            $tag = tag::find($id);

            if (request()->isMethod('post')) {
                $data = $this->validate(request(), [
                    'tag_name' => 'required|min:2|max:100|unique:tags|string',
                ]);

                $tag->tag_name = request()->get('tag_name');

                $tag->save();

                return redirect()->route('tags')->with('success', 'Data Update');
            }

            return view('admin.tags.update', ['tags' => $tag]);
        }else{
            return rediect()->back();
        }
    }

    public function search(Request $request)
    {
        if (Sentinel::hasAccess('admin.create')) {
            if ($request->isMethod('get')) {
                $tag = tag::where('tag_name', 'like', '%'.$request->get('search').'%')->paginate(5);

                $this->validate(request(), [
                    'search' => 'sometimes|required|string|max:60',
                ]);

                if ($tag->count() == 0) {
                    return redirect()->route('tags')->with('error', 'Data is not found');
                } else {
                    return view('admin.tags.search', ['tags' => $tag]);
                }
            }
       }else{
        return redirect()->back();
       }

    }



    public function delete($id){

        if (Sentinel::hasAccess('admin.create')) {
            $tags = tag::find($id);
                if ($tags != null)
                {
                    $tags->delete();
                    return redirect()->route('tags')->with('success','Data deleted');
                } else {
                    return redirect()->route('tags')->with('error', 'error database');
                }
            }else{
                return redirect()->back();
            }

    }
}
