<?php

namespace App\Http\Controllers;

use App\cart;
use App\cart_curriculum;
use App\cart_game;
use Illuminate\Http\Request;
use App\game;
use Session;
use App\curriculum;
use App\DataTables\yourOrderDataTable;
use App\Notifications\emailSupply;
use Sentinel;

class productControl extends Controller
{
    public function index(){

        $game = game::paginate(2);
        return view("product.index",["game"=>$game]);
    }

    public function add_session(Request $request){

        if(isset(Session::all()['games_id'])){
            if(in_array($request->id,Session::all()['games_id'])){
                return response(['status'=>"false","messsgae"=>"game has been add before"]);
             }else{
                Session::push("games_id",$request->id);
                return response(['status'=>"true"]);
             }
        }else{
            Session::push("games_id",$request->id);
            return response(['status'=>"true"]);
        }
    }

    public function add_session_curriculum(Request $request){

        if(isset(Session::all()['curriculum_id'])){
            if(in_array($request->id,Session::all()['curriculum_id'])){
                return response(['status'=>"false","messsgae"=>"Curriculum has been add before"]);
             }else{
                Session::push("curriculum_id",$request->id);
                return response(['status'=>"true"]);
             }
        }else{
            Session::push("curriculum_id",$request->id);
            return response(['status'=>"true"]);
        }
    }



    public function yourOrder(yourOrderDataTable $cart){

            return $cart->render("yourOrder");

    }

    public function multi_Delete(){


        if(is_array(request('item')))
        {
            cart::destroy(request('item'));
        }else{
            cart::find(request('item'))->delete();
        }

        return redirect()->route('yourOrder')->with('success', 'Data has been deleted successfully');

    }


    public function faninshCart(){

        if(empty(Session::all()['curriculum_id'])){
            Session()->forget('curriculum_id');
         }else if(empty(Session::all()['games_id'])){
            Session()->forget('games_id');
         }

         $output="";


         if( !empty(Session::all()['curriculum_id']) && !empty(Session::all()['games_id'])){

            $output ='<form method="post" id="insert_cart"><table class="table text-center">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Image</th>
                <th scope="col">Game name</th>
                <th scope="col" colspan="4">Comment</th>
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <tbody>
         ';


            foreach(Session::all()['games_id'] as $key => $value){

                foreach(game::where('id',$value)->get() as $game){
                    $output.=' <tr>

                    <td>


                    <div class="img-box">

                    <div class="aspect-ratio"></div>
                    <div class="aspect-content">
                    <img src="../upload/games/' . $game->img_main . '"/>
                    </div>

                </div>


                    </td>
                    <td>'.$game->game_name.'</td>
                     <td colspan="4"><textarea name="game_comment[]" id=""rows="3" class="form-control"></textarea></td>
                    <td>
                    <a href="" id='.$key.' class="remove_game"><i class="far fa-trash-alt text-danger"></i></a>
                    <input type="hidden" name="game_id[]" value='.$game->id.'>
                    </td>
                  </tr> ';
                }
            }

            $output.=" </tbody>
            </table>";

            $output.=' <table class="table text-center">
            <thead class="thead-dark">
              <tr>
                <th scope="col">image</th>
                <th scope="col">curriculum</th>
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <tbody>';
            foreach(Session::all()['curriculum_id'] as $key =>$value){

                foreach(curriculum::where('id',$value)->get() as $game){
                    $output.='<tr>
                          <td>   <div class="img-box">

                          <div class="aspect-ratio"></div>
                          <div class="aspect-content">
                          <img src="../upload/curricula/' . $game->image . '"/>
                          </div>

                      </div></td>


                    <td>
                    '.$game->name.'
                    </td>
                    <td>
                    <a href="" id='.$key.' class="remove_Curriculum">
                       <i class="far fa-trash-alt text-danger"></i>
                    </a>
                    <input type="hidden" name="curriculum_id[]" value='.$game->id.'>
                    </td>
                    </tr>
                    ';
                }
            }

            $output.=" </tbody>
            </table>

            <hr>

            ";


            $output.='<div class="form-group row">
            <label  class="col-3 col-lg-2 col-form-label text-right">Camp name</label>
            <div class="col-9 col-lg-10">
                <input  type="text" class="form-control" name="name_camp">
            </div>
        </div>

        <div class="form-group row">
            <label  class="col-3 col-lg-2 col-form-label text-right">Camp Date</label>
            <div class="col-9 col-lg-10">
                <input type="date" class="form-control" name="date_camp">
            </div>
        </div>


        <div class="form-group row">
            <label class="col-3 col-lg-2 col-form-label text-right">Administration</label>
            <div class="col-9 col-lg-10">
                <input type="text" class="form-control" name="administration">
            </div>
        </div>

        <div class="form-group row">
        <label class="col-3 col-lg-2 col-form-label text-right">other inforamtion</label>
        <div class="col-9 col-lg-10">
            <input type="text" class="form-control" name="other_inforamtion">
        </div>
    </div>

    <div class="row pt-2 pt-sm-5 mt-1">
    <div class="col-sm-6 pl-0">
        <p class="text-right">
            <button type="submit" class="btn btn-space btn-primary">Fanish cart</button>
            <div class="lds-hourglass"></div>
        </p>
    </div>
</div>

<div class="row" style="display: flex;justify-content: center;">
<div class="lds-hourglass"></div>
</div>

        ';
            $output.="</form>";


              return $output;



    }else if(!empty(Session::all()['games_id'])){
        $output ='<form method="post" id="insert_cart"><table class="table text-center">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Image</th>
            <th scope="col">Game name</th>
            <th scope="col" colspan="4">Comment</th>
            <th scope="col">Remove</th>
          </tr>
        </thead>
        <tbody>
     ';



        foreach(Session::all()['games_id'] as $key => $value){

            foreach(game::where('id',$value)->get() as $game){
                $output.=' <tr>

                <td>

                <div class="img-box">

                    <div class="aspect-ratio"></div>
                    <div class="aspect-content">
                    <img src="../upload/games/' . $game->img_main . '"/>
                    </div>

                </div>
                </td>
                <td>'.$game->game_name.'</td>
                 <td colspan="4"><textarea name="game_comment[]" id=""rows="3" class="form-control"></textarea></td>
                <td>
                <a href="" id='.$key.' class="remove_game"><i class="far fa-trash-alt text-danger"></i></a>
                <input type="hidden" name="game_id[]" value='.$game->id.'>
                </td>
              </tr> ';
            }
        }

        $output.=" </tbody>
        </table>

        <hr>";

        $output.='<div class="form-group row">
        <label  class="col-3 col-lg-2 col-form-label text-right">Camp name</label>
        <div class="col-9 col-lg-10">
            <input  type="text" class="form-control" name="name_camp">
        </div>
    </div>

    <div class="form-group row">
        <label  class="col-3 col-lg-2 col-form-label text-right">Camp Date</label>
        <div class="col-9 col-lg-10">
            <input type="date" class="form-control" name="date_camp">
        </div>
    </div>


    <div class="form-group row">
        <label class="col-3 col-lg-2 col-form-label text-right">Administration</label>
        <div class="col-9 col-lg-10">
            <input type="text" class="form-control" name="administration">
        </div>
    </div>

    <div class="form-group row">
    <label class="col-3 col-lg-2 col-form-label text-right">other inforamtion</label>
    <div class="col-9 col-lg-10">
        <input type="text" class="form-control" name="other_inforamtion">
    </div>
</div>

<div class="row pt-2 pt-sm-5 mt-1">
<div class="col-sm-6 pl-0">
    <p class="text-right">
        <button type="submit" class="btn btn-space btn-primary">Fanish cart</button>
        <div class="lds-hourglass"></div>
    </p>
</div>
</div>

<div class="row" style="display: flex;justify-content: center;">
<div class="lds-hourglass"></div>
</div>
    ';
        $output.="</form>";

        return $output;
    }else if(!empty(Session::all()['curriculum_id'])){

        $output ='<form method="post" id="insert_cart"><table class="table text-center">
        <thead class="thead-dark">
        <tr>
        <th scope="col">Image</th>
        <th scope="col">curriculum</th>
        <th scope="col">Remove</th>
    </tr>
        </thead>
        <tbody>
     ';


        foreach(Session::all()['curriculum_id'] as $key =>$value){

            foreach(curriculum::where('id',$value)->get() as $game){
                $output.='<tr>
                <td>



                <div class="img-box">

                    <div class="aspect-ratio"></div>
                    <div class="aspect-content">
                    <img src="../upload/curricula/' . $game->image . '"/>
                    </div>

                </div>

                </td>
                <td>
                '.$game->name.'
                </td>
                <td>
                <a href="" id='.$key.' class="remove_Curriculum"><i class="far fa-trash-alt text-danger"></i></a>

                <input type="hidden" name="curriculum_id[]" value='.$game->id.'>

                </td>
                </tr>
                ';
            }
        }

        $output.=" </tbody>
        </table>
        </div>
        <hr>";



        $output.='<div class="form-group row">
        <label  class="col-3 col-lg-2 col-form-label text-right">Camp name</label>
        <div class="col-9 col-lg-10">
            <input  type="text" class="form-control" name="name_camp">
        </div>
    </div>

    <div class="form-group row">
        <label  class="col-3 col-lg-2 col-form-label text-right">Camp Date</label>
        <div class="col-9 col-lg-10">
            <input type="date" class="form-control" name="date_camp">
        </div>
    </div>


    <div class="form-group row">
        <label class="col-3 col-lg-2 col-form-label text-right">Administration</label>
        <div class="col-9 col-lg-10">
            <input type="text" class="form-control" name="administration">
        </div>
    </div>

    <div class="form-group row">
    <label class="col-3 col-lg-2 col-form-label text-right">other inforamtion</label>
    <div class="col-9 col-lg-10">
        <input type="text" class="form-control" name="other_inforamtion">
    </div>
</div>

<div class="row pt-2 pt-sm-5 mt-1">
<div class="col-sm-6 pl-0">
    <p class="text-right">
        <button type="submit" class="btn btn-space btn-primary">Fanish cart</button>
    </p>
</div>
</div>

<div class="row" style="display: flex;justify-content: center;">
<div class="lds-hourglass"></div>
</div>

    ';
        $output.="</form>";


          return $output;

    }else if( empty(Session()->has('games_id')) && empty(Session()->has('curriculum_id'))){


        $output.='
         <div class="col-lg-12">
         <div class="alert alert-danger text-center">
           <p>Cart empty</p>
         </div>
         </div>
        ';
        return $output;
        }else if( empty(Session()->has('games_id')) || empty(Session()->has('curriculum_id'))){


            $output.='
             <div class="alert alert-danger">
               <p>Cart empty</p>
             </div>
            ';
            return $output;
            }




    }


    public function countCart(){

        $count_cart = 0 ;

        if(!empty(Session::all()['games_id']) && !empty(Session::all()['curriculum_id'])){
            $count_cart = count(Session::all()['games_id']) + count(Session::all()['curriculum_id']);
           }else if(!empty(Session::all()['games_id'])){
              $count_cart = count(Session::all()['games_id']);
           }else if(!empty(Session::all()['curriculum_id'])){
             $count_cart = count(Session::all()['curriculum_id']);
           }

           return $count_cart;
    }


    public function getCart(){

        if(empty(Session::all()['curriculum_id'])){
           Session()->forget('curriculum_id');
        }else if(empty(Session::all()['games_id'])){
           Session()->forget('games_id');
        }


        $output="";



        if( !empty(Session::all()['curriculum_id']) && !empty(Session::all()['games_id'])){
            foreach(Session::all()['games_id'] as $key => $value){

                foreach(game::where('id',$value)->get() as $game){
                    $output.='<div class="games_cart">
               <div class="row">

                   <div class="col-4">
                       <div class="box">
                          <img src="../upload/games/' . $game->img_main . '"/>
                       </div>
                   </div>
                   <div class="col-6">
                       <div class="game_name">
                           <p>'.$game->game_name.'</p>
                       </div>
                   </div>

                   <div class="col-2">
                   <a href="" id='.$key.' class="remove_game"><i class="far fa-trash-alt text-danger"></i></a>
                   </div>

               </div>
               </div>


           <hr>


          ';
                }
            }


            foreach(Session::all()['curriculum_id'] as $key =>$value){

                foreach(curriculum::where('id',$value)->get() as $game){
                    $output.='<div class="games_cart">
               <div class="row">

                   <div class="col-4">
                       <div class="box">
                          <img src="../upload/curricula/' . $game->image . '"/>
                       </div>
                   </div>
                   <div class="col-6">
                       <div class="game_name">
                           <p>'.$game->name.'</p>
                       </div>
                   </div>

                   <div class="col-2">
                   <a href="" id='.$key.' class="remove_Curriculum"><i class="far fa-trash-alt text-danger"></i></a>
                   </div>

               </div>
               </div>


           <hr>


          ';
                }
            }

            $output.=' <div class="text-center">
            <a href='.route("view_cart").' class="btn btn-primary col-lg">View cart</a>
          </div>';



              return $output;



    }else if(!empty(Session::all()['games_id'])){

        foreach(Session::all()['games_id'] as $item_game){

            foreach(game::where('id',$item_game)->get() as $game){
                $output.='<div class="games_cart">
           <div class="row">

               <div class="col-4">
                   <div class="box">
                      <img src="../upload/games/' . $game->img_main . '"/>
                   </div>
               </div>
               <div class="col-6">
                   <div class="game_name">
                       <p>'.$game->game_name.'</p>
                   </div>
               </div>

               <div class="col-2">
               <a href="" id='.$item_game.' class="remove_game"><i class="far fa-trash-alt text-danger"></i></a>
               </div>

           </div>
           </div>


       <hr>


      ';
            }
        }

        $output.=' <div class="text-center">
        <a href='.route("view_cart").' class="btn btn-primary col-lg">View cart</a>
          </div>';

          return $output;

       }else if(!empty(Session::all()['curriculum_id'])){



        foreach(Session::all()['curriculum_id'] as $key =>$value){

            foreach(curriculum::where('id',$value)->get() as $game){
                $output.='<div class="games_cart">
           <div class="row">

               <div class="col-4">
                   <div class="box">
                      <img src="../upload/curricula/' . $game->image . '"/>
                   </div>
               </div>
               <div class="col-6">
                   <div class="game_name">
                       <p>'.$game->name.'</p>
                   </div>
               </div>

               <div class="col-2">
                  <a href="" id='.$key.' class="remove_Curriculum"><i class="far fa-trash-alt text-danger"></i></a>
               </div>

           </div>
           </div>


       <hr>


      ';
            }
        }

        $output.=' <div class="text-center">
        <a href='.route("view_cart").' class="btn btn-primary col-lg">View cart</a>
          </div>';

          return $output;

    }else if( empty(Session()->has('games_id')) && empty(Session()->has('curriculum_id'))){


$output.='
 <div class="alert alert-danger">
   <p>Cart empty</p>
 </div>
';
return $output;
}





    }


    public function removeGame(Request $request){

        if($request->get("id") !=null){
            $id = $request->get("id");


            Session::forget('games_id.' . $id);

            if(count(Session::all()['games_id']) == 1){
                Session::forget('games_id');
            }

            return response(["state"=>"true"]);

        }else{
            return response(["state"=>"error"]);
        }

    }


    public function removeFanishGame(Request $request){

        if($request->get("id") !=null){
            $id = $request->get("id");


            Session::forget('games_id.' . $id);

            if(count(Session::all()['games_id']) == 0){
                Session::forget('games_id');
            }

            return response(["state"=>"true"]);

        }else{
            return response(["state"=>"error"]);
        }

    }


    public function insert_cart(Request $request){
        if (request()->ajax()) {

            $validator = \Validator::make($request->all(), [
                'name_camp' => 'required|string',
                'date_camp' => 'required|date',
                "administration"=> 'required|string',
                "other_inforamtion"=>'nullable|string',

            ]);


            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }



            if($request->get('curriculum_id') !=null && $request->get('game_id') !=null ){
                foreach ($request->game_id as $item => $value) {


                    $validator = \Validator::make($request->all(), [
                        'game_id.*' => 'required',
                        "game_comment.*" => "string",
                    ], [], [
                        "game_id" => "Game"
                    ]);
                }

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }


                foreach ($request->get('curriculum_id') as $item => $value) {


                    $validator = \Validator::make($request->all(), [
                        'curriculum_id.*' => 'required',
                    ], [], [
                        "curricula_id" => "curriculum"
                    ]);
                }

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }


                $data = array(
                    'date_order' => now(),
                    'id_user' => Sentinel::getUser()->id,
                    'name_camp' => $request->get("name_camp"),
                    'date_camp' => $request->get("date_camp"),
                    'administration' => $request->get("administration"),
                    'other_inforamtion'=> $request->get("other_inforamtion"),
                    "state" => "Pending"
                );


                $cart = cart::create($data);



                if (count($request->get('game_id')) > 0) {
                    if (is_array($request->get('game_id'))) {
                        foreach ($request->get('game_id') as $item => $value) {

                            $data2 = array(
                                'game_id' => $request->get('game_id')[$item],
                                'game_comment' => $request->get('game_comment')[$item],
                                'cart_id' => $cart->id,
                            );
                            $cart_game = cart_game::create($data2);
                        }
                    }
                }


                if (count($request->get('curriculum_id')) > 0) {
                    if (is_array($request->get('curriculum_id'))) {
                        foreach ($request->get('curriculum_id') as $item => $value) {

                            $data2 = array(
                                'curriculum_id' => $request->get('curriculum_id')[$item],
                                'cart_id' => $cart->id,
                            );
                            $cart_curriculum = cart_curriculum::create($data2);
                        }
                    }
                }

                Session::forget("curriculum_id");
                Session::forget("games_id");


                $role = Sentinel::findRoleBySlug("supply");
                $users = $role->users()->with('roles')->get();

                foreach ($users as $user) {
                    $notification = \App\User::find($user->id);
                    \Notification::send($notification ,new emailSupply($cart->id));
                }


               return response(["state"=>"true"]);



            }else if($request->curriculum_id !=null){
                foreach ($request->get('curriculum_id') as $item => $value) {


                    $validator = \Validator::make($request->all(), [
                        'curriculum_id.*' => 'required',
                    ], [], [
                        "curricula_id" => "curriculum"
                    ]);
                }

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }


                $data = array(
                    'date_order' => now(),
                    'id_user' => Sentinel::getUser()->id,
                    'name_camp' => $request->get("name_camp"),
                    'date_camp' => $request->get("date_camp"),
                    'administration' => $request->get("administration"),
                    'other_inforamtion'=> $request->get("other_inforamtion"),
                    "state" => "Pending"
                );


                $cart = cart::create($data);



                if (count($request->get('curriculum_id')) > 0) {
                    if (is_array($request->get('curriculum_id'))) {
                        foreach ($request->get('curriculum_id') as $item => $value) {

                            $data2 = array(
                                'curriculum_id' => $request->get('curriculum_id')[$item],
                                'cart_id' => $cart->id,
                            );
                            $cart_curriculum = cart_curriculum::create($data2);
                        }
                    }
                }


                Session::forget("curriculum_id");


                $role = Sentinel::findRoleBySlug("supply");
                $users = $role->users()->with('roles')->get();

                foreach ($users as $user) {
                    $notification = \App\User::find($user->id);
                    \Notification::send($notification ,new emailSupply($cart->id));
                }



               return response(["state"=>"true"]);


            }else if(isset($request->game_id)){
                foreach ($request->game_id as $item => $value) {


                    $validator = \Validator::make($request->all(), [
                        'game_id.*' => 'required',
                        "game_comment.*" => "string",
                    ], [], [
                        "game_id" => "Game"
                    ]);
                }

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()->all()]);
                }




                $data = array(
                    'date_order' => now(),
                    'id_user' => Sentinel::getUser()->id,
                    'name_camp' => $request->get("name_camp"),
                    'date_camp' => $request->get("date_camp"),
                    'administration' => $request->get("administration"),
                    'other_inforamtion'=> $request->get("other_inforamtion"),
                    "state" => "Pending"
                );


                $cart = cart::create($data);



                if (count($request->get('game_id')) > 0) {
                    if (is_array($request->get('game_id'))) {
                        foreach ($request->get('game_id') as $item => $value) {

                            $data2 = array(
                                'game_id' => $request->get('game_id')[$item],
                                'game_comment' => $request->get('game_comment')[$item],
                                'cart_id' => $cart->id,
                            );
                            $cart_game = cart_game::create($data2);
                        }
                    }
                }


                Session::forget("games_id");

                $role = Sentinel::findRoleBySlug("supply");
                $users = $role->users()->with('roles')->get();

                foreach ($users as $user) {
                    $notification = \App\User::find($user->id);
                    \Notification::send($notification ,new emailSupply($cart->id));
                }


               return response(["state"=>"true"]);


            }




        }

    }

    public function removeCurriculum(Request $request){

        if($request->get("id") !=null){
            $id = $request->get("id");


            Session::forget('curriculum_id.' . $id);


            return response(["state"=>"true"]);
        }else{
            return response(["state"=>"error"]);
        }

    }

    public function view_cart(){
        return view("view_cart");
    }

}

