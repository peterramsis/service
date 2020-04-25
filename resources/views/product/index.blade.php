@extends('layouts.app')
@section('title')
Well spring - product
@endsection
@section('content')

<div class="row">
   @foreach ($game as $game_item)
   <div class="col-lg-4">
      <div class="card">
         <div class="card-body">
            {{$game_item->game_name}}
            <p>
               {{ $game_item->description,2 }}
            </p>
            <img src="{{asset('upload/games/'.$game_item->img_main) }}" alt="" width="200">
            <div class="btns">
                  <form id="form" data-parsley-validate="" method="POST" action="create">
                        @csrf
               <input type="submit" class="btn btn-info addCart" value="Add to cart" >
               <input type="hidden" class="id" value="{{$game_item->id}}">

                  </form>
            </div>
         </div>
      </div>
   </div>
   @endforeach
</div>


@endsection


@section('js')

    <script>
         
       $(function(){
     
           $(".addCart").click(function(e){
              e.preventDefault();
            var id = $(this).parent().find(".id").val();

            $(this).attr("disabled","true");

            
            var _token = $('input[name="_token"]').val();

            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
               });
             
            $.ajax({
               url:"{{ route('addSession') }}",
               method:"POST",
               data:{id:id},
               success:function(result){
                 if(result == "true"){
                   alert("product add to cart");
                 }
               }

            });


           });
       });
    </script>
@endsection