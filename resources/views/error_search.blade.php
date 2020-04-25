@extends('layouts.app-site')

@section("title")
WellSpring-Serach
@endsection



@section('content')

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


   

@component('layouts.footer')
@endcomponent
@endsection
