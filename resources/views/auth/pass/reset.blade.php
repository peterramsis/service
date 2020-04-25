@extends('layouts.app')
@section('title')
reset password
@endsection

@section("css")

@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- reset password  -->
    <!-- ============================================================== -->
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="post" action="{{ route('reset') }}">
                    @csrf
                    <div class="login-form-head">
                        <h4>Reset Password</h4>
                        <p>Hey! Reset Your Password and comeback again</p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-gp">
                            <label for="confirm">confirmation Password</label>
                            <input type="password" id="confirm" name="password_confirmation">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="submit-btn-area mt-5">
                            <button id="form_submit" type="submit">Reset <i class="ti-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->
    <!-- ============================================================== -->
    <!-- end forgot password  -->
    <!-- ============================================================== -->
 @endsection
