@if(App::isLocale('ar'))
 @php
 $lan = "admin.layouts.app_ar";
 @endphp
@else
@php
 $lan = "admin.layouts.app_en";
 @endphp
@endif

@extends($lan)
@section('title')
{{ __('add user') }}
@endSection

@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("add user") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("users") }}</a></li>
      <li class="active"> {{ __("add user") }}</li>
    </ol>
  </section>
@endsection
@section("content")
@include('admin.layouts.messages')



<div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('add user') }}</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body" style="">
            <div class="card">

                <div class="card-body">

                    <form id="form" method="POST" action="{{ route('addUser') }}" enctype="multipart/form-data" role="form">
                        @csrf

                        <div class="box-body">
                            <div class="form-group">
                                <label>{{ __('Name') }}</label>
                                <input class="form-control form-control-lg" id="name" type="text"  name="name">
                              </div>
                            <div class="form-group">
                              <label>{{ __('Email address') }}</label>
                              <input type="text" name="email" class="form-control" value="{{ old('email') }}" dir="rtl" >
                            </div>
                            <div class="form-group">
                                <label>{{ __("Username") }}</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}" dir="rtl" >
                              </div>
                            <div class="form-group">
                              <label>{{ __("Password") }}</label>
                              <input class="form-control form-control-lg" id="password" type="password"  name="password">
                            </div>
                            <div class="form-group">
                                <label>{{ __("password confirmation") }}</label>
                                <input class="form-control form-control-lg" name="password_confirmation" type="password">
                              </div>


                            <div class="form-group">
                              <label for="exampleInputFile">{{ __("Photo") }}</label>
                              <input type="file" name="image" class="form-control" value="{{ old('image') }}">
                            </div>

                            <div class="form-group">
                                <label>{{ __("Birthday") }}</label>
                                <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
                              </div>



                            <div class="col-sm-6 pl-0">
                                <p class="text-right">
                                    <button type="submit" class="btn btn-space btn-primary">{{ __("create") }}</button>
                                </p>
                            </div>

                          </div>

                    </form>

                </div>
            </div>
        </div>
        <!-- /.box-footer-->
      </div>


@endsection

