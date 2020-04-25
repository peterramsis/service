@extends('layouts.app')

@section("title")
WellSpring-Games
@endsection




@section('content')

   
<div class="all">
    <div class="container">
          <header>
                <div class="cat">
                        <div class="container"> 
                          <div class="row cats" style="justify-content: center;">
                                @foreach ($dept as $item)

                            
                               
                                
                                 @if ($item->parent_id == "")

                                 
                                 

                                 <a 
                                   
                                
                                     @if ($item->is_sup != 1)
                                          href="#"
                                     @else
                                     class="ws-open" 
                                     @endif
                               
 
                                 >

                             
                                      <div class="col-lg-2 col-sm-6 col-md-3">
                                              <div class="box" style="flex-direction: column;">
                                                <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" width="100px;"/>     
                                              </div>
                                            </div>
                                 </a>
                      
                                 
                                  

                                   <div class="ws-window">
                                    <a href="#" class="ws-close"> <i class="fas fa-times" style="color: #ff5454;"> </i> Close </a>
                                    <div class="container">
                                        <div class="row" style="justify-content: center; margin-top:100px;">

                                     @foreach ($dept as $item_child)

                                       @if($item_child->parent_id == $item->id)

                                        
                                                <div class="col-lg-2 col-md-3 col-6">
                                                    <div class="box" style="flex-direction: column; justify-content: center">
                                                      <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" width="100px;"/>     
                                                    </div>
                                                
                                                  </div>
                                           

                                       @endif
                                          
                                     @endforeach
                                    </div>
                                </div>
                                       
                                    
                                   </div>

                                

                                   
                                    
                                    
                                 @endif
    
                                @endforeach
                            
                          </div>
          </header>
     </div>
</div>
@endsection


@section('js')
<script src="{{ asset('js/animatedModal.min.js') }}"></script>
<script>

    $(function(){
        $(".ws-window").hide();
        $(".ws-close").on("click", function(e) {
            e.preventDefault();
            $(this).parents(".cats").find(".ws-window").hide(1000);
        });

        $(".ws-open").on("click", function() {
            $(this).next(".ws-window").show(1000);
        });

    });
        
 </script>
@endsection
