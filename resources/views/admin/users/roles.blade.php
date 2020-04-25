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

@section("breadcrumbs")
<div class="breadcrumbs-area clearfix">
    <h4 class="page-title pull-left">Users</h4>
    <ul class="breadcrumbs pull-left">
        <li><a href="{{ route("admin") }}">Dashboard</a></li>
        <li><a href="{{ route("mangeUsers") }}">Users</a></li>
        <li><span>Role</span></li>
    </ul>
</div>
@endsection

@include('admin.layouts.messages')

<div class="card">
    <h5 class="card-header">
             <a href="{{ route('add_role') }}" class="btn btn-primary">Create Roles</a>
    </h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Permission</th>
                        <th scope="col">update</th>
                        <th scope="col">delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

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
                                <td><a href="{{ route('updateRole', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                                <td><a href="{{ route('deleteRole', $item->id) }}" class="btn btn-danger"><i class="far fa-trash-alt"  onclick="return confirm('Are you sure?')"></i></a></td>

                            </tr>
                        @endforeach

                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
