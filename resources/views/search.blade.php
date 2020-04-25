@extends('layouts.app-site')

@section("title")
WellSpring-Serach
@endsection



@section('content')
@component('layouts.component.cart')
      <div class="cart_fetch">
 
      </div>
     @endcomponent
@component('layouts.header')
Search :  {{request()->get("search")}}
@endcomponent

      <div class="breadcrumb-site">
          
    <div class="container">
            <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Search</li>
                          </ol>
                  </nav>
    </div>
      </div>
      {{--  breadcrumb-site   --}}


      <div class="container">
            @include('layouts.messages')
    </div>

      <div class="container">
            <div class="mb-2 text-header">
                    <h3 class="text-dart text-capitalize">Search</h3>
                 </div>
      </div>

      <div class="container">

        <div class="search-cat">
          @component('layouts.component.search')

          @endcomponent
         </div>
        <div class="row">
             
           @if (count($game) > 0)
                  @foreach ($game as $item)
                  <div class="col-lg-4 col-sm-12 col-md-6 games-padding">
                          <div class="card-game">  
                              <img src="{{ asset('upload/games/'.$item->img_main) }}"/>
                              <div class="game-title">
                                  <h3 class="lead">{{$item->game_name}}</h3>
                                  <p>{{substr($item->des, 0, 60)}}</</p>
                              </div>
                          </div>


                          <div class="ws-model-cart">
                            <span class="open-model-cart btn btn-primary"><i class="fas fa-eye"></i></span>
                            <div class="body-model" style="display:none">
                              <div class="overlay"></div>
                              <div class="cart-model">
                                <div class="cart-close"><i class="fas fa-times-circle btn-close"></i></div>
                                <div class="cart-body">
                                  <h4 class="text-center">{{$item->game_name}}</h4>
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
                                         <p>{{ $item->description}}</p>
                                      </div>
                                      <div class="rules">
                                      <pre>{{$item->rules}}</pre>
                                       </div>
                                      <div class="number_of_player">
                                        <p>{{$item->number_of_player_game->number_of_player}}</p>
                                      </div>
                                      <div class="age">{{$item->age_game->age}}</div>
                                      <div class="video">
                                       <a href='{{$item->video }}'>Link</a>
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
                    
                     @foreach ($item->item as $items)
                   
                           <tr>
                   
                           <td>{{$items->item_name}}</td>
                           <td>{{$items->pivot->qty}}</td>
                           </tr>
             
                     @endforeach
                  </tbody>
                </table>
                
                                       
                                       </div>
                                      </div>
                                      <div class="attachment">
                                       <a href=' {{ $item->attachment}} '>Link</a>
                                      </div>
                
                                      <div class="images">
                                     
                                     <div class="row">
                                     
                                    
                    @foreach ($item->images as $item_image)
                    <div class="col-lg-3 col-12">
                      <div class="img-box">
                                             
                      <div class="aspect-ratio"></div>
                      <div class="aspect-content">
                      <img src=" {{ asset('upload/games/'.$item_image->name_image) }}" class="img-gallery">
                      </div>
                      
                  </div>
                      
                  </div>
                    @endforeach
                                    
                                    
                                     
                                     </div>
                                       
                                     
                                  </div>
                
                                     </div>
                
                                     <!--end -->
                                    </div>
                                  
                                  </div>
                                  
                                  </div>
                
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          
                  
                  @endforeach
                  @elseif(count($curriculum) > 0)

                  @foreach ($curriculum as $item)
                  <div class="col-lg-4 col-sm-12 col-md-6 games-padding">
                              <div class="card-game">  
                              <img src="{{ asset('upload/curricula/'.$item->image) }}"/>
                                <div class="game-title">
                                  <h3 class="lead">{{$item->name}}</h3>
                                  <p>{{substr($item->des, 0, 60)}}....</</p>
                                </div>
                              </div>

                              <div class="ws-model-cart">
                                <span class="open-model-cart btn btn-primary"><i class="fas fa-eye"></i></span>
                                <div class="body-model" style="display:none">
                                  <div class="overlay"></div>
                                  <div class="cart-model">
                                    <div class="cart-close"><i class="fas fa-times-circle btn-close"></i></div>
                                    <div class="cart-body">
                                      <h4 class="text-center">{{$item->name }}</h4>
                                      <div class="container">
                                      
                                      <div class="row">
                                      
                                      <div class="dynamic-tab">
                                        <ul class="tabs-list">
                                          <li class="active" data-content=".description">Description</li>
                                          <li data-content=".attachment">Attachment</li>
                                        </ul>
                                
                                        <div class="content-list">
                                          <div class="description">
                                             <p>{{$item->des}}</p>
                                          </div>
                                
                                
                                          
                                          <div class="attachment">
                                          <a href='{{ $item->attachment }}'>Link</a>
                                          </div>
                                
                                
                                
                                
                                         <!--end -->
                                        </div>
                                      
                                      </div>
                                      
                                      </div>
                                
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </div>
                              </div>
                  @endforeach
                
                  @else 
                   <div class="container">
                       <div class="alert alert-danger text-center">
                            Database empty
                       </div>
                   </div>
           @endif
        </div>
        @if (count($game) > 0)
        {{ $game->links() }} 
        @elseif(count($curriculum) > 0)
        {{ $curriculum->links() }}
        @else 
         
        @endif
    </div>

@component('layouts.footer')
@endcomponent
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
 <script>
  
    $(function(){


        $.get("{{route('getCart')}}",function(data,rt,xhh){
         
            $('.cart_fetch').html("");
            $('.cart_fetch').html(data);
           
        }); 
      
          
          $(".ws-window").hide();
          $(".ws-close").on("click", function(e) {
              e.preventDefault();
              $(this).parents(".cats").find(".ws-window").hide(1000);
          });
  
          $(".ws-open").on("click", function() {
              $(this).next(".ws-window").show(1000);
          });


          
    });

    $(document).on("click",".add-to-cart-game",function(){
      var id = $(this).attr("id");
      var _token = $('input[name="_token"]').val();
 
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
      $.ajax({
        type: "POST",
        url: "{{route('addGame')}}",
        data: {id:id},
        success: function(result){
               if(result.status == "true"){

                $(".body-model").hide(10);
            

                Swal.fire(
                  'Good job!',
                  'game has been added to cart',
                  'success'
                )

                $.get("{{route('getCart')}}",function(data,rt,xhh){
         
                  $('.cart_fetch').html("");
                  $('.cart_fetch').html(data);
                 
              }); 

                
        

                
               }else if(result.status == "false"){

                  $(".body-model").hide(10);
                
                
                  Swal.fire({
                    type: 'error',
                    text: "Game has been added before",
  
                  })
               }
        },
        
      });
      
    });


    $(document).on("click",".remove_game",function(e){
      e.preventDefault();
      var id = $(this).attr("id");
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
     $.ajax({
       type: "POST",
       url: "{{route('remove_game')}}",
       data: {id:id},
       success: function(result){
              if(result.state == "true"){
                
                Swal.fire(
                  'success',
                  'Game has been remove to cart',
               );

               $.get("{{route('getCart')}}",function(data,rt,xhh){
        
                 $('.cart_fetch').html("");
                 $('.cart_fetch').html(data);
                
             }); 

             
                               
                
              }else if(result.status == "false"){
               
               Swal.fire({
                 type: 'error',
                 text: "Game has been remove before",

               })
              }
       },
       
     });

    });

    $(document).on("click",".remove_Curriculum",function(e){
      e.preventDefault();
      var id = $(this).attr("id");
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
     $.ajax({
       type: "POST",
       url: "{{route('removeCurriculum')}}",
       data: {id:id},
       success: function(result){
              if(result.state == "true"){
                
                Swal.fire(
                  'success',
                  'Curriculum has been remove from cart',
               );

               $.get("{{route('getCart')}}",function(data,rt,xhh){
        
                 $('.cart_fetch').html("");
                 $('.cart_fetch').html(data);
                
             }); 

             
                               
                
              }else if(result.status == "false"){
               
               Swal.fire({
                 type: 'error',
                 text: "Curriculum has been remove before",

               })
              }
       },
       
     });

    });


    $(document).on("click",".add-to-cart-curriculum",function(){
      var id = $(this).attr("id");
      var _token = $('input[name="_token"]').val();
 
      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
      $.ajax({
        type: "POST",
        url: "{{route('addCurriculum')}}",
        data: {id:id},
        success: function(result){
               if(result.status == "true"){

                $(".body-model").hide(10);
                 
                 Swal.fire(
                   'success',
                  'curriculum has been added to cart',
                );

                $.get("{{route('getCart')}}",function(data,rt,xhh){
         
                  $('.cart_fetch').html("");
                  $('.cart_fetch').html(data);
                 
              }); 

              
                                
                 
               }else if(result.status == "false"){

                $(".body-model").hide(10);
                
                Swal.fire({
                  type: 'error',
                  text: "Curriculum has been added before",

                })
               }
        },
        
      });
      
    });

 </script>
@endsection


