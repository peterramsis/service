@extends('layouts.app-site')

@section("title")
WellSpring - cart
@endsection

    @section('content')

   
    @component('layouts.header')
    <h2>Cart</h2>
    @endcomponent
    
          <div class="breadcrumb-site">
              
        <div class="container">
                <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Cart</li>
                              </ol>
                      </nav>
        </div>
          </div>
          {{--  breadcrumb-site   --}}
    
          <div class="container">
                <div class="mb-2 text-header">
                        <h3 class="text-dart text-capitalize">Cart</h3>
                     </div>
          </div>
    
    
          <div class="container">
    
            <div class="search-cat">
              @component('layouts.component.search')
    
              @endcomponent
             </div>
              <div class="row">
                
                <div class="col-lg-12 col-col-12">
                    <div class="cartFanish">
    
                    </div>
                </div>
                  
               
              </div>
          </div>
    
    @component('layouts.footer')
    @endcomponent
    
              
    
    @endsection
    
    @section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{ asset('js/fakeLoader.js') }}"></script>
     <script>
      
        $(function(){
    
            $.get("{{route('getFanish')}}",function(data,rt,xhh){
             
                $('.cartFanish').html("");
                $('.cartFanish').html(data);

                $(".lds-hourglass").hide();
               
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
           url: "{{route('removeFanishGame')}}",
           data: {id:id},
           success: function(result){
                  if(result.state == "true"){
                    
                    Swal.fire(
                      'success',
                      'Game has been remove to cart',
                   );
    
                   $.get("{{route('getFanish')}}",function(data,rt,xhh){
             
                    $('.cartFanish').html("");
                    $('.cartFanish').html(data);
                    $(".lds-hourglass").hide();
                   
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
    
                   $.get("{{route('getFanish')}}",function(data,rt,xhh){
             
                    $('.cartFanish').html("");
                    $('.cartFanish').html(data);
                    $(".lds-hourglass").hide();
                   
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


        $(document).on("submit","#insert_cart",function(e){


          e.preventDefault();


          $(".btn-primary").hide();
          $(".lds-hourglass").show();

   
          
          var _token = $('input[name="_token"]').val();

          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
             });


             


          $.ajax({
            type: "POST",
            url: "{{route('insert_cart')}}",
            data: $(this).serialize(),
            success: function(result){

              
                   if(result.state == "true"){
                     
                    Swal.fire(
                      'Good job!',
                      'order done wait for replay!',
                      'success'
                    )

                    
                   $.get("{{route('getFanish')}}",function(data,rt,xhh){
             
                    $('.cartFanish').html("");
                    $('.cartFanish').html(data);
                   
                }); 

               

                window.location.href = "{{route("yourOrder")}}";
                $(".lds-hourglass").hide();
                           
                     
                   }else if(result.errors){
                    Swal.fire({
                       type: 'error',
                       html: result.errors.toString().replace(",","<br>")
   
                     })

                     $(".btn-primary").show();
                       }
            },
            
          });
     

        });
    
    
      
     </script>
    </div>
    @endsection
    







