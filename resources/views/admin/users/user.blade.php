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
      {{ __("users") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashborad") }}</a></li>
      <li class="active"> {{ __("users") }}</li>
    </ol>
  </section>
@endsection
@section("content")
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
                  <a href="{{ route('addUser') }}" class="btn btn-primary">{{ __("create User") }}</a>
                </h5>

                <div class="card-body">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover text-center">
                          <tbody><tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __("username") }}</th>
                            <th scope="col">{{ __("full name") }}</th>
                            <th scope="col">{{ __("Permission") }}</th>
                            <th scope="col">{{ __("update") }}</th>
                            <th scope="col">{{ __("delete") }}</th>

                        </tbody>

                        @foreach ($users as $item)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->name}}</td>
                                            <td>
                                                @foreach ($item->roles as $item_r)
                                                    {{ $item_r->name }}
                                                @endforeach
                                            </td>

                                            <td><a href="{{ route('userUpdate', $item->id) }}"><i class="fa fa-pencil"></i></a></td>
                                            <td><a href="{{ route('deleteUsers',$item->id) }}"><i class="fa fa-trash-o"  onclick="return confirm('Are you sure?')"></i></a></td>
                                        </tr>
                                    @endforeach
                    </table>
                      </div>

                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer" style="">
            {{ $users->links() }}
        </div>
        <!-- /.box-footer-->
      </div>


@endsection
