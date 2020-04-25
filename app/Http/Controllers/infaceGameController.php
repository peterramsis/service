<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\game;
use App\curriculum;
use App\department;
use App\tag;

class infaceGameController extends Controller
{
  public function lastGame()
  {

    $game = \App\game::orderBy("id", "DESC")->take(10)->get();


    $output = "";

    foreach ($game as $item) {

      $image = "";

      foreach ($item->images as $item_image) {
        $image .= '
             <div class="col-lg-3 col-12">
             <div class="img-box">
                                    
             <div class="aspect-ratio"></div>
             <div class="aspect-content">
                <img src="upload/games/' . $item_image->name_image . '" class="img-gallery">
             </div>
             
         </div>
             
         </div>
             
             ';
      }


      $output_tr = "";
      foreach ($item->item as $items) {

        $qty = $items->pivot->qty;
        $output_tr .= "
              <tr>
      
              <td>$items->item_name</td>
              <td>$qty</td>
              </tr>

            ";
      }



      $output .= '
            
            <div class="col-lg-4 col-sm-12 col-md-6 card-ws">
            <div class="card-game">    
             <img src="upload/games/' . $item->img_main . '"/>
              <div class="game-title">
                <h6 class="lead">' . $item->game_name . '</h6>
              </div>
            </div>

            <div class="ws-model-cart">
            <span class="open-model-cart btn btn-primary"><i class="fas fa-eye"></i></span>
            <div class="body-model" style="display:none">
              <div class="overlay"></div>
              <div class="cart-model">
                <div class="cart-close"><i class="fas fa-times-circle btn-close"></i></div>
                <div class="cart-body">
                  <h4 class="text-center">' . $item->game_name . '</h4>
                  <div class="container">
                  
                  <div class="row">
                  
                  <div class="dynamic-tab">
                    <ul class="tabs-list">
                      <li class="active" data-content=".description">Description</li>
                      <li data-content=".rules">Rules</li>
                      <li data-content=".number_of_player">Number of player</li>
                      <li data-content=".age">Age</li>
                      <li data-content=".video">video</li>
                      <li data-content=".item">Material</li>
                      <li data-content=".attachment">Attachment</li>
                      <li data-content=".images">Images</li>
                      
                    </ul>

                    <div class="content-list">
                      <div class="description">
                         <p>' . $item->description . '</p>
                      </div>
                      <div class="rules">
                      <pre>' . $item->rules . '</pre>
                       </div>
                      <div class="number_of_player">
                        <p>' . $item->number_of_player_game->number_of_player . '</p>
                      </div>
                      <div class="age">' . $item->age_game->age . '</div>
                      <div class="video">
                       <a href=' . $item->video . '>Link</a>
                      </div>
                      <div class="item">
                       <div class="table-responsive">
                       
                       <table class="table table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Item</th>
                              <th scope="col">qty</th>
                            </tr>
                          </thead>
                          <tbody>
                          ' . $output_tr . '
                            
                          </tbody>
                        </table>
                        <!--end table-->
                       </div>
                       <!--end table-responsive-->
                      </div>
                      <!--end item-->
                      <div class="attachment">
                       <a href=' . $item->attachment . '>Link</a>
                      </div>

                      <div class="images">
                     
                     <div class="row">
                     
                    
                     
                     ' . $image . '
                    
                     
                     </div>
                       
                     
                  </div>
                  <!--end images-->

                     </div>

                     <!--end -->
                    </div>
                  
                  </div>
                  
                  </div>

                  </div>
                  
                  <div class="cart-add">
                  <i class="fas fa-cart-arrow-down text-primary fa-2x add-to-cart-game" id='.$item->id.'></i>
                  </div>
                  <!--end cart add-->
                </div>
               
              </div>

              

            </div>
          </div>

          </div>  
            ';
    }

    echo $output;
  }


  public function lastCurriculum()
  {

    $game = curriculum::orderBy("id", "DESC")->take(10)->get();


    $output = "";

    foreach ($game as $item) {
      $output .= '

      <div class="col-lg-4 col-sm-12 col-md-6">
<div class="card-game">  
<img src="upload/curricula/' . $item->image . '"/>
  <div class="game-title">
    <h3 class="lead">' . $item->name . '</h3>
    <p>' . substr($item->des, 0, 60) . '......</</p>
  </div>
</div>

<div class="ws-model-cart">
<span class="open-model-cart btn btn-primary"><i class="fas fa-eye"></i></span>
<div class="body-model" style="display:none">
  <div class="overlay"></div>
  <div class="cart-model">
    <div class="cart-close"><i class="fas fa-times-circle btn-close"></i></div>
    <div class="cart-body">
      <h4 class="text-center">' . $item->name . '</h4>
      <div class="container">
      
      <div class="row">
      
      <div class="dynamic-tab">
        <ul class="tabs-list">
          <li class="active" data-content=".description">Description</li>
          <li data-content=".attachment">Attachment</li>
        </ul>

        <div class="content-list">
          <div class="description">
             <p>'.$item->des.'</p>
          </div>


          
          <div class="attachment">
          <a href=' . $item->attachment . '>Link</a>
          </div>




         <!--end -->
        </div>
      
      </div>
      
      </div>

      </div>

      <div class="cart-add">
                  <i class="fas fa-cart-arrow-down text-primary fa-2x add-to-cart-curriculum" id='.$item->id.'></i>
                  </div>
    </div>
  </div>
</div>
</div>


</div>
        
        
        ';
    }

    echo $output;
  }


  public function cats()
  {
    $dept = department::whereNull("parent_id")->orderBy("id", "DESC")->get();


    $output = "";

    foreach ($dept as $item) {
      $output .= '
 <div class="col-lg-2 col-sm-6 col-md-3">
                <div class="box" style="flex-direction: column;">
                  <img src="upload/dept/' . $item->icon . '" width="100px;"/>     
                   <div>
                <span style="font-size: 10px;color: #007cae;">' . $item->dept_name . '</span>
                </div>
                </div>


               



                
               
                
              </div>
        
        
        ';
    }

    echo $output;
  }

  public function pageCat($id)
  {
    $games = game::where("dept_id", $id)->paginate(20);
    $curriculum = curriculum::where("dept_id", $id)->paginate(20);

    $dept = department::where("id", $id)->first();

    return view("cat", ["game" => $games, "curriculum" => $curriculum, "dept" => $dept]);
  }

  public function pageTag($tag){

  

    $games = game::whereHas("tag", function ($query) use ($tag) {
        $query->where("tag_name", $tag);
    })->paginate(5);

  


    return view("tag", ["game" =>  $games,"tag" => $tag]);

  }

  public function pageSearch(Request $request)
  {

    if ($request->isMethod('get')) {

      $this->validate(request(), [
        'search' => 'sometimes|required|string|max:60',
      ]);

      $game = game::whereHas("department", function ($query) use ($request) {
        return $query->where("dept_name", "like", '%' . $request->get('search') . '%');
      })->orWhere('game_name', 'like', '%' . $request->get('search') . '%')
      ->orWhereHas("number_of_player_game", function ($query) use ($request) {
        return $query->where("number_of_player", "like", '%' . $request->get('search') . '%');
      })
        ->orWhereHas("age_game", function ($query) use ($request) {
          return $query->where("age", "like", '%' . $request->get('search') . '%');
        })->paginate(20)->setPath('');

      $arr = explode(",", $request->get('search'));


      $game_two = game::whereHas("tag", function ($query) use ($arr) {
        foreach ($arr as $item) {
          $query->whereIn("tag_name", $arr);
        }
      })->paginate(5)->setPath('');


      $game = $game->appends(array(
        'search' => $request->get('search')
      ));


      $curriculum = curriculum::whereHas("department", function ($query) use ($request) {
        return $query->where("dept_name", "like", '%' . $request->get('search') . '%');
      })->orWhere('name', 'like', '%' . $request->get('search') . '%')
        ->paginate(5)->setPath('');

      if ($game->count() != 0) {


        $game = $game->appends(array(
          'search' => $request->get('search')
        ));
        return view('search', ['game' => $game])->withData($game);
      } else if ($game_two->count() != 0) {

        $game = $game_two;
        $game = $game->appends(array(
          'search' => $request->get('search')
        ));
        return view('search', ['game' => $game])->withData($game);
      } else if ($curriculum->count() != 0) {

        $curriculum = $curriculum->appends(array(
          'search' => $request->get('search')
        ));

        return view('search', ['curriculum' => $curriculum])->withData($curriculum);
      } else {

        return redirect()->route("error_search")->with("error", "data has been not found");
      }
    } else {
      return redirect()->route("error_search")->with("error", "data has been not found");
    }
  }

  public function error_search()
  {
    return view("error_search");
  }
}
