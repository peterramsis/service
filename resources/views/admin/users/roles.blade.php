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
{{ app()->getlocale() =="ar" ? "الصلاحيات" : "roles" }}
@endSection
@section("content")

@section("breadcrumb")
<section class="content-header">
    <h1>
      {{ __("roles") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashborad") }}</a></li>
      <li class="active"> {{ __("roles") }}</li>
    </ol>
  </section>
@endsection

@include('admin.layouts.messages')

<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">{{ __('users') }}</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body" style="">
        <div class="card">
            <h5 class="card-header">
                <a href="{{ route('add_role') }}" class="btn btn-primary">{{ __("create role") }}</a>
            </h5>



            <div class="card-body">

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover text-center">
                      <tbody><tr>
                        <th scope="col">#</th>

                        <th scope="col">{{ __("name permission") }}</th>
                        <th scope="col">Slug</th>
                        <th scope="col">{{ __("permission") }}</th>

                        <th scope="col">{{ __("delete") }}</th>

                        @foreach ($roles as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>
                                @foreach ($item->permissions as $key => $value)
                                    @if ($value == 1)
                                        {{ $key."=>". "true" }}
                                        @else
                                        {{ $key."=>". "false" }}
                                    @endif
                                @endforeach
                            </td>

                            <td><a href="{{ route('deleteRole', $item->id) }}" class="btn btn-danger"><i class="fa fa-trash-o"  onclick="return confirm('Are you sure?')"></i></a></td>

                        </tr>
                    @endforeach

                    </tbody>


                </table>
                  </div>

            </div>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer" style="">

    </div>
    <!-- /.box-footer-->
  </div>



@endsection
