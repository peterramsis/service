@extends('admin.layouts.app')
@section('title')
   Well spring - Add role
@endsection
@section("content")
@include('admin.layouts.messages')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}" class="breadcrumb-link">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add role</li>
    </ol>
</nav>
<div class="card">
    <h5 class="card-header">Add role</h5>
    <div class="card-body">
        <form id="form" data-parsley-validate="" method="POST" action="{{ route('updateRole',$role->id) }}">
            @csrf
         


            <div class="form-group row">
                <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Name</label>
                <div class="col-9 col-lg-10">
                      <input type="text" name="name" class="form-control" value="{{ $role->name }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Slug</label>
                <div class="col-9 col-lg-10">
                      <input type="text" name="slug" class="form-control" value="{{ $role->slug }}">
                </div>
            </div>

         
        
           
            <div class="row pt-2 pt-sm-5 mt-1">
                
                <div class="col-sm-6 pl-0">
                    <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">create</button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection