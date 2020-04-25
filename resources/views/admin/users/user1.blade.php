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
{{ __('users') }}
@endSection


@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("edit user") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashborad") }}</a></li>
      <li class="active"> {{ __("users") }}</li>
    </ol>
  </section>
@endsection
@section("content")




<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('edit user') }}</h3>

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



                <form id="form" data-parsley-validate="" method="POST" action="{{ route('userUpdate',$user->id) }}">
                    @csrf

                    <div class="box-body">
                        <div class="form-group">
                            <label>{{ __('Username') }}</label>
                            <input id="inputEmail2" type="text" data-parsley-type="username" placeholder="username" class="form-control" disabled value="{{ $user->username }}">
                        </div>

                        <div class="form-group">
                            <label>{{ __('roles') }}</label>
                            <select name="role" id="" class='form-control '>
                                @foreach (Sentinel::findById($user->id)->roles as $item_r)
                                 @foreach ($roles as $item)
                                   @if ($item_r->name == $item->name)
                                       <option value="{{ $item->slug }}" selected>{{ $item->slug }}</option>
                                       @else
                                       <option value="{{ $item->slug }}">{{ $item->slug }}</option>
                                   @endif
                                 @endforeach
                               @endforeach


                   </select>
                        </div>


                        <div class="form-group">
                            <label>{{ __("Real Permisssion") }}</label>
                            @foreach (Sentinel::findById($user->id)->permissions as $key => $value)

                                  @if ($value == 1)
                                      <br>
                                      {{ $key."=>"."true"}}
                                      @else
                                      <br>
                                      {{ $key."=>"."false"}}
                                  @endif

                                @endforeach
                        </div>

                          </div>

                    <div class="row pt-2 pt-sm-5 mt-1">

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
