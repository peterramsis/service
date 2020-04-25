@extends('layouts.app')
@section('title')
Forgot password
@endsection

@section("css")

@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- forgot password  -->
    <!-- ============================================================== -->


    <div class="login-area">
        <div class="container">


            <div class="row pt--20">
                <div class="col-12 col-md-12">
                    @include('admin.layouts.messages')
                </div>
            </div>

            <div class="login-box">

                <form method="post" action="{{ route('forget') }}">
                    @csrf
                    <div class="login-form-head">
                        <h4>forgot password</h4>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label for="email">Email address</label>
                            <input type="email" id="email" name="email">
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>

                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>

    @endsection
