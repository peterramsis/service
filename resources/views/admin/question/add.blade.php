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
{{ __('add question') }}
@endSection

@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("add question") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashbaord") }}</a></li>
      <li><a href='{{route("question")}}'> {{ __("question") }}</a></li>
      <li class="active"> {{ __("add question") }}</li>
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

                    <form id="form" method="POST" action="create" role="form">
                        @csrf

                        <div class="box-body">
                            <div class="form-group">
                                <label>{{ trans("qu.question arabic") }}</label>
                                <input class="form-control form-control-lg" type="text"  name="question_ar">
                              </div>
                            <div class="form-group">
                              <label>{{ trans("qu.question english") }}</label>
                              <input type="text" name="question_en" class="form-control" value="{{ old('question_en') }}" >
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

