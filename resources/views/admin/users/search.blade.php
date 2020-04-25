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
      {{ __("Search user") }}
    </h1>
    <ol class="breadcrumb">
      <li><a href='{{route("home")}}'><i class="fa fa-home"></i> {{ __("home") }}</a></li>
      <li><a href='{{route("admin")}}'><i class="fa fa-dashboard"></i> {{ __("dashborad") }}</a></li>
      <li><a href='{{route("mangeUsers")}}'><i class="fa fa-dashboard"></i> {{ __("users") }}</a></li>
      <li class="active"> {{ __("search user") }}</li>
    </ol>
  </section>
@endsection
@section("content")
@include('admin.layouts.messages')



<div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ __('search user') }}</h3>
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

                <form action="{{ route('search_user') }}" method="GET" class="formSearch">

                    <div class="form-group">
                        <div class="form-group">
                            <input type="search" name="search" class="search form-control" placeholder="Search the user">
                        </div>
                    </div>
                </form>

                <div class="card-body">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover text-center">
                          <tbody><tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ __("username") }}</th>
                            <th scope="col">{{ __("Name") }}</th>
                            <th scope="col">{{ __("Email address") }}</th>
                            <th scope="col">{{ __("roles") }}</th>
                            <th scope="col">{{ __("phone") }}</th>
                            <th scope="col">{{ __("mobile") }}</th>
                            <th scope="col">{{ __("instagram") }}</th>
                            <th scope="col">{{ __("twitter") }}</th>
                            <th scope="col">{{ __("facebook") }}</th>
                            <th scope="col">{{ __("religion") }}</th>
                            <th scope="col">{{ __("sect") }}</th>
                            <th scope="col">{{ __("church") }}</th>
                            <th scope="col">{{ __("edit") }}</th>
                            <th scope="col">{{ __("delete") }}</th>

                        </tbody>

                        @foreach ($users as $item)

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->name}}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                @foreach ($item->roles as $item_r)
                                                    {{ $item_r->name }}
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $item->phone }}
                                            </td>
                                            <td>
                                                {{ $item->mobile }}
                                            </td>
                                            <td>
                                               @if($item->instagram !="")
                                               <a href="{{ $item->instagram }}">{{ __("link") }}</a>
                                               @endif
                                            </td>
                                            <td>
                                                @if($item->twitter !="")
                                                <a href="{{ $item->twitter }}">{{ __("link") }}</a>
                                                @endif
                                             </td>
                                             <td>
                                                @if($item->facebook !="")
                                                <a href="{{ $item->facebook }}">{{ __("link") }}</a>
                                                @endif
                                             </td>
                                             <td>
                                                 {{ $item->religion }}
                                             </td>
                                             <td>
                                                {{ $item->sect }}
                                            </td>
                                            <td>
                                                {{ $item->church }}
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
