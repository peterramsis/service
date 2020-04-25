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
{{ __('settings') }}
@endSection

@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("settings") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashborad") }}</a></li>
      <li class="active">    {{ __("settings") }}</li>
    </ol>
  </section>
@endsection
@section("content")
@include('admin.layouts.messages')



<div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">   {{ __("settings") }}</h3>

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

                    <form id="form" method="POST" action="{{ route("updateSetting",$setting->id) }}" role="form">
                        @csrf

                        <div class="box-body">
                            <div class="form-group">
                                <label>{{ trans("setting.meta_keywords_ar") }}</label>
                                <input class="form-control form-control-lg" type="text"  name="meta_keywords_ar" value="{{$setting->meta_keywords_ar }}">
                              </div>


                              <div class="form-group">
                                <label>{{ trans("setting.meta_keywords_en") }}</label>
                                <input class="form-control form-control-lg" type="text"  name="meta_keywords_en" value="{{$setting->meta_keywords_en }}">
                              </div>

                              <div class="form-group">
                                <label>{{ trans("setting.meta_description_ar") }}</label>
                                <input class="form-control form-control-lg" type="text"  name="meta_description_ar" value="{{$setting->meta_description_ar }}">
                              </div>

                              <div class="form-group">
                                <label>{{ trans("setting.meta_description_en") }}</label>
                                <input class="form-control form-control-lg" type="text"  name="meta_description_en" value="{{$setting->meta_description_en }}">
                              </div>


                              <div class="form-group">
                                <label>{{ trans("setting.about_us_en") }}</label>
                                <textarea class="form-control" name="about_us_en">{{$setting->about_us_en }}</textarea>
                              </div>

                              <div class="form-group">
                                <label>{{ trans("setting.about_us_ar") }}</label>
                                <textarea class="form-control" name="about_us_ar">{{$setting->about_us_ar }}</textarea>
                              </div>





                            <div class="col-sm-6 pl-0">
                                <p class="text-right">
                                    <button type="submit" class="btn btn-space btn-primary">{{ __("update") }}</button>
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

