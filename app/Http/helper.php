<?php

if(!function_exists("load_dept")){

    function load_dept($select = null,$dept_id = null){

        $department = \App\department::selectRaw("dept_name as text")->
        selectRaw("id as id")->
        selectRaw("parent_id as parent_id")
        ->get(['text','id','parent_id']);

        $dept_arr = [];
        foreach ($department as $dept) {
            $list = [];
            $list['icon']='';
            $list['li_attr'] = '';
            $list['a_attr']='';
            $list['children'] ='';
            if($select !== null and $select == $dept->id){


                $list['state']=[
                    "opened"=>true,
                    "selected"=>true,
                    "disabled"=>false
                ];
            }

            if($dept_id !== null and $dept_id == $dept->id){


                $list['state']=[
                    "opened"=>false,
                    "selected"=>false,
                    "disabled"=>true,
                    "hidden" =>true
                ];
            }

            $list['id'] = $dept->id;
            $list['parent'] = $dept->parent_id > 0 ? $dept->parent_id : "#";
            $list['text'] = $dept->text;
            array_push($dept_arr,$list);


        }



        return json_encode($dept_arr,JSON_UNESCAPED_UNICODE);

    }

}
