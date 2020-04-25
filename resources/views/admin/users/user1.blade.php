@extends('admin.layouts.app')
@section('title')
   Well spring - Upadte User {{  "(".$user->username.")" }})
@endsection
@section("content")
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin" class="breadcrumb-link">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update User </li>
    </ol>
</nav>
<div class="card">
    <h5 class="card-header">Update User {{ $user->username }}</h5>
    <div class="card-body">
        <form id="form" data-parsley-validate="" method="POST" action="{{ route('userUpdate',$user->id) }}">
            @csrf
            <div class="form-group row">
                <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Username</label>
                <div class="col-9 col-lg-10">
                    <input id="inputEmail2" type="text" data-parsley-type="username" placeholder="username" class="form-control" disabled value="{{ $user->username }}">
                </div>
            </div>




            <div class="form-group row">
                <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Role</label>
                <div class="col-9 col-lg-10">
                        <select name="role" id="" class='form-control '>




                                     @foreach (Sentinel::findById($user->id)->roles as $item_r)
                                      @foreach ($roles as $item)
                                        @if ($item_r->name == $item->name)
                                            <option value="{{ $item->slug }}" selected>{{ $item->slug }}</option>
                                            @else
                                            <option value="{{ $item->slug }}">{{ $item->slug }}</option>
                                        @endif
                                      @endforeach
                                    @endforeach


                        </select>
                </div>
            </div>



            <div class="form-group row">
                <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Real Permisssion</label>
                <div class="col-9 col-lg-10">

                   @foreach (Sentinel::findById($user->id)->permissions as $key => $value)

                          @if ($value == 1)
                              <br>
                              {{ $key."=>"."true"}}
                              @else
                              <br>
                              {{ $key."=>"."false"}}
                          @endif

                        @endforeach
                </div>
            </div>



            <div class="row pt-2 pt-sm-5 mt-1">

                <div class="col-sm-6 pl-0">
                    <p class="text-right">
                        <button type="submit" class="btn btn-space btn-primary">Update</button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
