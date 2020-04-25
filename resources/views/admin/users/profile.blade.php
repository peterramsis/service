@extends('admin.layouts.app')

@section('title')
   Well spring - update profile
@endsection
@section("content")
@include('admin.layouts.messages')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}" class="breadcrumb-link">Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
    </ol>
</nav>


<div class="card">
    <h5 class="card-header">Update Profile</h5>
    <div class="card-body">
         <form id="form" data-parsley-validate="" method="POST" action="{{ route('changeProfile',Sentinel::getUser()->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Email</label>
                <div class="col-9 col-lg-10">
                    <input id="inputEmail2" type="email" class="form-control" disabled value="{{ Sentinel::getUser()->email }}">
                </div>
            </div>

            <div class="form-group row">
                
                 <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Username</label>
                <div class="col-9 col-lg-10">
                    <input id="inputEmail2" type="email" class="form-control" disabled value="{{ Sentinel::getUser()->username }}">
                </div>
            </div>

            <div class="form-group row">
                
                 <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">First Name</label>
                <div class="col-9 col-lg-10">
                    <input id="inputEmail2" type="text" class="form-control" name="first_name"  value="{{ Sentinel::getUser()->first_name }}">
                </div>
            </div>

            <div class="form-group row">
                
                 <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Last Name</label>
                <div class="col-9 col-lg-10">
                    <input id="inputEmail2" type="text" class="form-control" name="last_name"  value="{{ Sentinel::getUser()->last_name }}">
                </div>
            </div>

            <div class="form-group row">
                
                 <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Birthday</label>
                <div class="col-9 col-lg-10">
                    <input id="inputEmail2" type="date" class="form-control" name="birthday"  value="{{ Sentinel::getUser()->birthday }}">
                </div>
            </div>

            <div class="form-group row">
                        <label for="inputEmail2" class="col-3 col-lg-2 col-form-label text-right">Image profile</label>
                        <div class="col-9 col-lg-10">
                            <input type="file" name="image"  class="form-control img_game">{{ old('game_img') }}</textarea>
                            <img src="{{  asset("upload/user/". Sentinel::getUser()->image)  }}" alt="" style="margin:15px;width:30%" class='img-perview'>
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

@section("js")
<script>
        function readURL(input) {

            if (input.files && input.files[0]) {
              var reader = new FileReader();
          
              reader.onload = function(e) {
                $('.img-perview').attr('src', e.target.result);
              }
          
              reader.readAsDataURL(input.files[0]);
            }
          }
          
          $(".img_game").change(function() {

            readURL(this);
          });
</script>
@endsection