@extends('layouts.app-site')

@section("title")
WellSpring - Your order
@endsection

@section('css')
    
@endsection



@section('content')
@component('layouts.component.cart')
      <div class="cart_fetch">
 
      </div>
     @endcomponent


@component('layouts.header')
<h2>Your order</h2>
@endcomponent



      <div class="breadcrumb-site">
          
    <div class="container">
            <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Your order</li>
                          </ol>
                  </nav>
    </div>
      </div>
      {{--  breadcrumb-site   --}}

      <div class="container">
            <div class="mb-2 text-header">
                    <h3 class="text-dart text-capitalize">Your order</h3>
                 </div>


                 <div class="search-cat">
                  @component('layouts.component.search')
      
                  @endcomponent
                 </div>
      </div>


   

      
      <div class="container">
          <div class="row">

            <div class="card">


                <div class="card-body">
                        <div class="table-responsive">
            
                          {!! Form::open(["id"=>"form_data","url"=> route("multi_Delete_order"),"method"=>"delete"]) !!}
            
                          {!! Form::hidden('_method','delete') !!}
            
                          {!! $dataTable->table(['class' => 'table  table-bordered text-center'],true) !!}
            
                          {!! Form::close() !!}
                        </div>
                </div>
            </div>
               
          </div>
      </div>

      {{ $dataTable->scripts() }}

@component('layouts.footer')
@endcomponent

          

@endsection

@section("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    function check_all(){

        $('input[class="item_checked"]:checkbox').each(function(){
            if($('input[class="check_all_item"]:checkbox:checked').length == 0){
               $(this).prop("checked",false)


            }else{
                $(this).prop("checked",true);

            }
        });

    }


  

    $(document).on("click",".del_all",function(){



        if($('input[class="item_checked"]:checkbox:checked').length > 0){

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                    $("#form_data").submit();
                }
              })

        }else{

            Swal.fire({
                title: 'Please chose something to delete',
                type: 'warning',
            })
        }


     });




</script>

@endsection



