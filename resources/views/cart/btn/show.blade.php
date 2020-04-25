
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-{{$id}}">
  Show 
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body">
        

        @if (count($game) > 0)
        <h3>Games</h3>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Game name</th>
                <th>Item</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($game as $item_game)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                      <div class="img-box">
                                      
                          <div class="aspect-ratio"></div>
                          <div class="aspect-content">
               
                              <img src="{{ asset('upload/games/'.$item_game->img_main) }}" alt="img" width="200px">
                          </div>
                          
                      </div>
                    </td>
                    <td>{{$item_game->game_name}}</td>
                    <td>
                      <table class="table table-condensed">
                          <thead>
                            <tr>
                              <th scope="col">item</th>
                              <th scope="col">qty</th>
                            </tr>
                          </thead>
                          <tbody>
                     @foreach ($item_game->item as $game_items)
                         <tr>
                             <td>{{$game_items->item_name}}</td>
                             <td>{{$game_items->pivot->qty}}</td>
                         </tr>
                     @endforeach
  
                          </tbody>
                      </table>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        @endif


        <hr>

        @if (count($curriculum) > 0)
        <h3>curriculum</h3>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">curriculum</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($curriculum as $item_curriculum)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                      <div class="img-box">
                                      
                          <div class="aspect-ratio"></div>
                          <div class="aspect-content">
               
                              <img src="{{ asset('upload/curricula/'.$item_curriculum->image) }}" alt="img" width="200px">
                          </div>
                          
                      </div>
                    </td>
                    <td>{{$item_curriculum->name}}</td>
                  </tr>
                 
              @endforeach
            </tbody>
          </table>
        @endif


        @if (count($game) > 0)

        <h3>Items</h3>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">item</th>
                <th scope="col">qty</th>
              </tr>
            </thead>
            <tbody>

              @php
              $sumArray = [];   


              
              foreach ($game as $item_game){
                foreach ($item_game->item as $items){
                 if(isset($sumArray[$items->item_name])){
                  $sumArray[$items->item_name] += $items->pivot->qty;
                 }else{
                  $sumArray[$items->item_name] = $items->pivot->qty;
                 }
                }
               
              }

              
                
              @endphp


              @foreach ($game as $item_game)
              @foreach ($item_game->item as $items)
               
              
               
              <tr>
              
                <td>{{$items->item_name}}</td>
                <td>{{$sumArray[$items->item_name]}}</td>
               </tr>
               


              @endforeach

              
            @endforeach

              
              
              
           </tbody>
          </table>  
        @endif
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div