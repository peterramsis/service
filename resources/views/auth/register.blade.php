@extends('layouts.app')
@section('title')
Register
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
    <div class="login-box ptb--100">
        <form method="post" class="form-reg">
            <div class="login-form-head">
                <h4>Sign up</h4>
                <p>Hello there, Sign up and Join with Us</p>
            </div>
            <div class="login-form-body">
                <div class="form-gp">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name">
                    <i class="ti-user"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="form-gp">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                    <i class="ti-user"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="form-gp">
                    <label for="image">Image profile</label>
                    <input type="file" id="image" name="image">
                    <i class="ti-gallery"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="form-gp">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email">
                    <i class="ti-email"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="form-gp">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <i class="ti-lock"></i>
                    <div class="text-danger"></div>
                </div>
                <div class="form-gp">
                    <label for="exampleInputPassword2">Confirm Password</label>
                    <input type="password" id="exampleInputPassword2" name="password_confirmation">
                    <i class="ti-lock"></i>
                    <div class="text-danger"></div>
                </div>

                <div class="submit-btn-area">
                    <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                </div>
                <div class="form-footer text-center mt-5">
                    <p class="text-muted">Don't have an account? <a href="{{ route("/") }}">Sign in</a></p>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<!-- login area end -->

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(function(){




        $(".form-reg").on("submit",function(e){
            e.preventDefault();

            var _token = $('input[name="_token"]').val();

            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
             });


             $.ajax({
                 url:"{{route('register')}}",
                 method:"POST",
                 data:  new FormData(this),
                 contentType: false,
                 ache: false,
                 processData:false,
                 success:function(result){
                     if(result.errors){
                         Swal.fire({
                             type: 'error',
                             title: 'Oops...',
                             text: result.errors,

                           })
                     }else if(result.success){

                         $("#password").val("");
                         $("#email").val("");
                         $("#name").val("");
                         $("#username").val("");
                        Swal.fire({

                            type: 'success',
                            title: result.success,
                            showConfirmButton: false,
                            timer: 3000
                        })

                        window.location.href = "/";

                     }
                 },error:function(err,exp){
                     if(exp == 'error'){
                        Swal.fire({
                          title: 'Error!',
                          text: err.data,
                          type: err.responseJSON.message,
                          confirmButtonText: 'Ok'
                        })
                     }
                  },

             })



         });

    });
</script>
@endsection

