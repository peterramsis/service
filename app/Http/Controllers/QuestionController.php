<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\DataTables\questionDataTable;
use App\question;

class QuestionController extends Controller
{
    public function index(questionDataTable $question){
        if(Sentinel::hasAnyAccess(['admin.*'])){
            return $question->render("admin.question.all");
        }else{
            return redirect()->back();
        }
    }

    public function multi_Delete(){


        if(is_array(request('item')))
        {

            $arr = [];

            foreach(request('item') as $item){
               $curriculm =  question::find($item);

               if($curriculm->image != ""){
                 unlink(public_path('upload/curricula/' . $curriculm->image));
               }
            }

            question::destroy(request('item'));


        }else{
            question::find(request('item'))->delete();

        }

        if(app()->getlocale() == "ar"){
            return redirect()->route('question')->with('success', 'تم المسح بنجاح');
        }else{
            return redirect()->route('question')->with('success', "Data has been delete successfully");

        }

    }


    public function create(){

        if(Sentinel::hasAnyAccess(['admin.*'])){
            if (request()->isMethod('post'))
            {
                $data = $this->validate(request(), [
                        'question_ar' => 'required|string',
                        'question_en' => 'required|string',
               ]);

                $question = question::create($data);

                if(app()->getlocale() == "ar"){
                    return redirect()->route('question')->with('success', 'تم الاضافة بنجاح');
                }else{
                    return redirect()->route('question')->with('success', "Data has been added successfully");

                }
            }

            return view('admin.question.add');

    }
}

public function update($id)
{
    if(Sentinel::hasAnyAccess(['admin.*'])){
    $question = question::find($id);

    if (request()->isMethod('post'))
    {
        $data = $this->validate(request(), [
            'question_ar' => 'required|string',
            'question_en' => 'required|string',
        ]);

        $question->question_ar = request()->get('question_ar');
        $question->question_en = request()->get('question_en');
        $question->save();
        if(app()->getlocale() == "ar"){
            return redirect()->route('question')->with('success', 'تم التعديل بنجاح');
        }else{
            return redirect()->route('question')->with('success', 'Data has been Updated successfully');
        }
    }

    return view('admin.question.update', ['question' => $question]);


}else{
    return redirect()->back();
}
}

}
