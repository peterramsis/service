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
{{ __('add role') }}
@endSection

@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("create role") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("users") }}</a></li>
      <li class="active"> {{ __("create role") }}</li>
    </ol>
  </section>
@endsection
@section("content")
@include('admin.layouts.messages')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('create role') }}</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
<div class="card">
    <div class="card-body">
        <form id="form" data-parsley-validate="" method="POST" action="{{ route('add_role') }}">
            @csrf

            <div class="box-body">
                <div class="form-group">
                    <label>{{ __('name permission') }}</label>
                    <input type="text" name="name" class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control">
                  </div>

            </div>

            <div class="row pt-2 pt-sm-5 mt-1">

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
@endsection
