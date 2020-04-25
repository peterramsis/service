<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\setting;

class SettingController extends Controller
{

    public function update(Request $request){

      $setting = setting::findOrfail(1);

      if(request()->isMethod("post")){


        $this->validate(request(), [
            "meta_keywords_ar"=>"required|string",
            "meta_keywords_en"=>"required|string",
            "meta_description_ar"=>"required|string",
            "meta_description_en"=>"required|string",
            "about_us_en"=>"required|string",
            "about_us_ar"=>"required|string",
        ]);

        $setting->meta_keywords_ar =  $request->meta_keywords_ar;
        $setting->meta_keywords_en =  $request->meta_keywords_en;
        $setting->meta_description_ar =  $request->meta_description_ar;
        $setting->meta_description_en =  $request->meta_description_ar;
        $setting->about_us_en =$request->about_us_en;
        $setting->about_us_ar =$request->about_us_ar;
        $setting->save();

        if(app()->getlocale() == "ar"){
          return redirect()->route('updateSetting')->with('success', 'تم التعديل بنجاح');
      }else{
          return redirect()->route('updateSetting')->with('success', "Data has been added successfully");

      }

      }

      return view("admin.setting.update",["setting"=>$setting]);


    }
}
