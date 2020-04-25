@extends('layouts.app')
@section('title')
Login
@endsection

@section("css")

@endsection
@section('content')

<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- preloader area start -->
<div id="preloader">
<div class="loader"></div>
</div>
<!-- preloader area end -->
<!-- login area start -->
<div class="login-area">
<div class="container">
    <div class="row pt--20">
        <div class="col-12 col-md-12">
            @include('admin.layouts.messages')
        </div>
    </div>
    <div class="login-box ptb--100">

        <form method="post" id="form-login">
            <div class="login-form-head">
                <h4>Sign In</h4>
                <p>Sign in and start managing your Admin Panal</p>
            </div>
            <div class="login-form-body">
                <div class="form-gp">
                    <label for="email">Email address</label>
                    <input type="text" id="email" name="email">
                    <i class="ti-email"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="form-gp">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <i class="ti-lock"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="row mb-4 rmber-area">
                    <div class="col-6">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing" name="remember">
                            <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('forget') }}">Forgot Password?</a>
                    </div>
                </div>
                <div class="submit-btn-area">
                    <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                </div>
                <div class="form-footer text-center mt-5">
                    <p class="text-muted">Don't have an account? <a href="{{ route('register') }}">Sign up</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection



@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(function(){

        // ajax login
        $("#form-login").on("submit",function(e){
            e.preventDefault();
            var _token = $('input[name="_token"]').val();

            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

             var data = $(this).serialize();

             $.ajax({
                 url:"{{route('login')}}",
                 method:"POST",
                 data:data,
                 success:function(result){
                     if(result.errors){
                         Swal.fire({
                             type: 'error',
                             text: result.errors,

                           })
                     }else if(result.data == "admin"){

                         window.location.href = "admin";

                     }else if(result.data == "user"){

                         window.location.href = "home";

                     }
                 },error:function(err,exp){
                     if(exp == 'error'){
                        Swal.fire({
                          title: 'Error!',
                          text: err.responseJSON.message,
                          icon: 'error',
                          confirmButtonText: 'Ok'
                        })
                        console.log(err.responseJSON.errors);
                     }
                  }
             })



         });



    });
</script>
@endsection
