<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\tag;
use App\game;
use Intervention\Image\ImageManagerStatic as Image;
use App\images_game;
use App\item;
use App\games_item;
use App\age;
use App\numberOfPlayer;
use App\attathcment_game;

class gameControll extends Controller
{

    public function index()
    {

        if (Sentinel::hasAccess('admin.create')) {
            $games = game::orderBy('id', 'desc')->paginate(5);
            return view("admin.games.all", ["games" => $games]);
        } else {
            return redirect()->back();
        }
    }


    public function search(Request $request)
    {
        if (Sentinel::hasAccess('admin.create')) {
            if ($request->isMethod('get')) {
                $this->validate(request(), [
                    'search' => 'sometimes|required|string|max:60',
                ]);

                //->
                $game = game::whereHas("department",function($query) use ($request){
                   return $query->where("dept_name","like",'%'.$request->get('search').'%');
                })->orWhere('game_name', 'like', '%'.$request->get('search').'%')
                ->orWhereHas("age",function($query) use ($request){
                    return $query->where("ages","like",'%'.$request->get('search').'%');
                 })->orWhereHas("number_of_player",function($query) use ($request){
                    return $query->where("number_of_players","like",'%'.$request->get('search').'%');
                 })->paginate(5)->setPath('');


                $arr = explode(",",$request->get('search'));


                $game_two = game::whereHas("tag",function($query) use($arr){
                    foreach($arr as $item){
                    $query->whereIn("tag_name",$arr);
                  }
                })->paginate(5)->setPath('');



                 $game = $game->appends ( array (
                    'search' => $request->get('search')
                  ));



                if ($game->count() == 0) {
                    
                    if($game_two->count() == 0){
                        return redirect()->route('games')->with('error', 'Data has been not found');
                    }else{
                        $game = $game_two;
                        $game = $game->appends ( array (
                            'search' => $request->get('search')
                          ));
                        return view('admin.games.search', ['games' => $game])->withData($game);
                    }

                } else {
                    return view('admin.games.search', ['games' => $game])->withData($game);
                }

            }
       }else{
        return redirect()->back();
       }

    }

    public function update($id)
    {

        if (Sentinel::hasAccess('admin.create')) {
            $game = game::find($id);
            $age = age::all();
            $number = numberOfPlayer::all();

            $id = [];
            foreach ($game->tag as $item) {
                $id[] = $item->id;
            }

            $id_age = [];
            foreach ($game->age as $item) {
                $id_age[] = $item->id;
            }




            $tags = tag::whereNotIn("id", $id)->get();
            $ages = age::whereNotIn("id_age", $id_age)->get();
           
            $item = item::all();

            if (request()->isMethod('post')) {

                //dd(request()->img_main);
                $this->validate(request(), [
                    'game_name' => 'required|min:2|max:100|string',

                    'description' => 'required|string',
                    'video' => 'nullable',
                    'dept_id' => 'required',
                    'tag_id' => 'required',
                    'rules' => 'required',
                    "age_id_age" => "required",
                    "number_of_player" => "required"

                ],[],[
                    "age_id_age" =>"age"
                ]);

                foreach (request()->item_id as $item => $value) {
                    $this->validate(request(), [
                     'item_id.*' => 'required',
                     "qty.*" => "required|integer",
                     
                ]);
                }

                if (request()->img_main != "") {

                    if ($game->img_main != "") {
                        unlink(public_path('upload/games/' . $game->img_main));
                    }

                    Image::make(request()->img_main)->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path('upload/games/' . request()->img_main->hashName()));


                    $image = request()->img_main->hashName();
                } else {
                    $image = $game->img_main;
                }


                $game->game_name = request()->game_name;
                $game->img_main =  $image;
                $game->description = request()->description;
    
                $game->video =  request()->video;
                $game->dept_id = request()->dept_id;
                $game->rules = request()->rules;
                $game->number_of_player = request()->number_of_player;
                $game->save();
                $game->tag()->sync(request()->tag_id);
                $game->age()->sync(request()->age_id_age);
                
                  

                if (is_array(request()->item_id)) {
                    foreach (request()->item_id as $item => $value) {
                        $data2 = array(
                            'item_id' => request()->item_id[$item],
                            'qty' => request()->qty[$item],
                            'game_id' => $game->id,
    
                        );
                        games_item::updateOrCreate(['game_id' => $game->id,"item_id" => request()->item_id[$item]], $data2);
                    }
                }


                if(request()->attachment !="")
                {
                    foreach(request()->attachment as $item => $value){

                        if(request()->file('attachment') !="")
                        {
                                $file = request()->attachment[$item];

                                $file_name = $file->getClientOriginalName();
                                $file->storeAs('public/upload/files/', $file_name);

                        } else 
                        {
                                $file_name = "";
                        }

                        $data2 = array(
                            'attachment' =>  $file_name,
                            'game_id' => $game ->id
                        );
                        $item_game = attathcment_game::create($data2);
                    }
                }

                
                 

                return redirect()->route('upload_game', ['id' => $game->id])->with('success', 'Data Added and Now add images for game');
            }




            return view("admin.games.update", ["game" => $game, 'tag' => $tags,"ages" => $ages, 'material' => $item, "number"=>$number,"age"=>$age]);
        } else {
            return redirect()->back();
        }
    }


    public function upload($id)
    {
        if (Sentinel::hasAccess('admin.create')) {


            if (request()->isMethod("post")) {

                Image::make(request()->file)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/games/' . request()->file->hashName()));


                $data = array(
                    "game_id" => $id,
                    "name_image" => request()->file->hashName()
                );

                images_game::create($data);
            }


            return view("admin.games.upload", ['id' => $id]);
        } else {
            return redirect()->back();
        }
    }


    public function delete($id)
    {

        if (Sentinel::hasAccess('admin.create')) {

            $game = game::findOrfail($id);

            if ($game) {

                $game->delete();
                return redirect()->route("games")->with("success", "Game has been deleted successfully");
            }
        } else {
            return redirect()->back();
        }
    }



    public function delete_item(Request $request)
    {
        if(Sentinel::hasAccess("admin.*")){
            $value = $request->get('id');

            $item = games_item::find($value);

            $item->delete();

            return response()->json(['state' => 'delete']);
        }
    }

    public function lastGame(){

         $game = game::orderBy("id","DESC")->limit(10);
         
         if($game){
             return response(["data"=>$game]);
         }else{
             return response(["data","empty"]);
         }

    }

    
    public function insert_ajax(Request $request){
  
        if (Sentinel::hasAccess('admin.create')) {
            $tags = tag::all();
            $item = item::all();
            $age = age::all();
            $number = numberOfPlayer::all();
            if (request()->isMethod('post')) {
               

                $validator = \Validator::make($request->all(), [
                    'game_name' => 'required|min:2|max:100|string',
                    'img_main' => 'required',
                    'description' => 'required|string',
                    'video' => 'nullable',
                    'dept_id' => 'required',
                    'tag_id' => 'required',
                    'rules' => 'required',
                    'age_id_age' => 'required',
                    'number_of_player' => 'required',
                    'attachment' => 'nullable'
    
                ], [], [
                    "dept_id" => "Department",
                    "tag_id" => "Tags",
                    "age_id_age" => "age"
                ]);

               

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }
    
    

            

                foreach ($request->item_id as $item => $value) {
                   
                    $validator = \Validator::make($request->all(), [
                        'item_id.*' => 'required',
                        "qty.*" => "required",
        
                    ]);
                }
    
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }

                Image::make($request->img_main)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/games/' . $request->img_main->hashName()));


                $data = array(
                    'game_name' => $request->game_name,
                    'img_main' =>  $request->img_main->hashName(),
                    'description' => $request->description,
                    'video' => $request->video,
                    'dept_id' => $request->dept_id,
                    'rules' => $request->rules,
                    'number_of_player' => $request->number_of_player,
                );

                $game = game::create($data);
                $game->tag()->sync($request->tag_id);
                $game->age()->sync($request->age_id_age);


                if (count($request->item_id) > 0) {
                    if (is_array($request->item_id)) {
                        $array_id = [];
                        foreach ($request->item_id as $item => $value) {
                            $data2 = array(
                                'item_id' => $request->item_id[$item],
                                'qty' => $request->qty[$item],
                                'game_id' => $game->id
                            );
    
                            $item_game = games_item::create($data2);
                        }
                    }
                }

                if($request->attachment !="")
                {
                    foreach($request->attachment as $item => $value){

                        if($request->file('attachment') !="")
                        {
                                $file = $request->attachment[$item];

                                $file_name = $file->getClientOriginalName();
                                $file->storeAs('public/upload/files/', $file_name);

                        } else 
                        {
                                $file_name = "";
                        }

                        $data2 = array(
                            'attachment' =>  $file_name,
                            'game_id' => $game ->id
                        );
                        $item_game = attathcment_game::create($data2);
                    }
                }



                return response(["state" => "true" , "route" => route('upload_game',$game->id)]);


               
            }
            
        } else {
            return redirect()->back();
        }

      }

    public function create()
    {
        if (Sentinel::hasAccess('admin.create')) {
            $tags = tag::all();
            $item = item::all();
            $age = age::all();
            $number = numberOfPlayer::all();
            if (request()->isMethod('post')) {
                $this->validate(request(), [
                    'game_name' => 'required|min:2|max:100|string',
                    'img_main' => 'required',
                    'description' => 'required|string',
                    'video' => 'nullable',
                    'dept_id' => 'required',
                    'tag_id' => 'required',
                    'rules' => 'required',
                    'age' => 'required',
                    'number_of_player' => 'required',
                    'attachment' => 'string|nullable'

                ]);

            

                foreach (request()->item_id as $item => $value) {
                    $this->validate(request(), [
                        'item_id.*' => 'required',
                        "qty.*" => "required",
                    ]);
                }

                Image::make(request()->img_main)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('upload/games/' . request()->img_main->hashName()));


                $data = array(
                    'game_name' => request()->game_name,
                    'img_main' =>  request()->img_main->hashName(),
                    'description' => request()->description,
                    'video' => request()->video,
                    'dept_id' => request()->dept_id,
                    'rules' => request()->rules,
                    'age' => request()->age,
                    'number_of_player' => request()->number_of_player,
                    'attachment' => request()->attachment
                );

                $game = game::create($data);
                $game->tag()->sync(request()->tag_id);


                if (count(request()->item_id) > 0) {
                    if (is_array(request()->item_id)) {
                        $array_id = [];
                        foreach (request()->item_id as $item => $value) {
                            $data2 = array(
                                'item_id' => request()->item_id[$item],
                                'qty' => request()->qty[$item],
                                'game_id' => $game->id
                            );
    
                            $item_game = games_item::create($data2);
                        }
                    }
                }


                return redirect()->route('upload_game', ['id' => $game->id])->with('success', 'Data Added and Now add images for game');
            }
            return view('admin.games.add', ['tag' => $tags, 'material' => $item,"age"=>$age,"number"=>$number]);
        } else {
            return redirect()->back();
        }
    }


    public function deleteFile($id){

        $att_file = attathcment_game::find($id);

        if($att_file !=null){
            $att_file->delete();
            return redirect()->route("games")->with("success","file has been deleted");
        }else{
            return redirect()->route("games")->with("error","file is not exist");
        }

    }

    public function download_attachment($attch){

        return response()->download(storage_path("app/public/upload/files/{$attch}"));
    }
    
}
