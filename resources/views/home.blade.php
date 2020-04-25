@extends('layouts.app')

@section("title")
Home
@endsection

@include('layouts.navbar')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <div class="d-flex justify-content-center align-items-center" style="height:400px">
                         <div class="alert alert-danger">
                            <h4>Your account doesn't have any permission to enter admin panel</h4>
                         </div>
                    </div>
            </div>
        </div>
    </div>

@endsection
