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
{{ app()->getlocale() =="ar" ? "لوحة التحكم" : "Dashboard" }}
@endSection
@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("dashborad") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-dashboard"></i> {{ __("home") }}</a></li>
      <li class="active"> {{ __("dashborad") }}</li>
    </ol>
  </section>
@endsection

@section('content')

 @if ($user = Sentinel::getUser())
    @if ($user->inRole('admin'))



<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">{{ __("users") }}</span>
          <span class="info-box-number">
            @if (isset($users))
            {{ $users }}
        @endif
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div><!-- /.col -->

  </div>
    @endif
@endif

@endsection
