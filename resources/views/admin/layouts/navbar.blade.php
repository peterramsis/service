<div class="main-menu">
    <div class="menu-inner">
        <nav>
            <ul class="metismenu" id="menu">
                <li class={{ Request()->route()->named('admin')? "active" : "" }}>
                    <a href="{{ route('admin') }}" aria-expanded="true"><i class="ti-dashboard"></i><span>Dashboard</span></a>
                </li>
                <li class={{ Request()->route()->named("mangeUsers") || Request()->route()->named("allRole") ? "active" :"" }}>
                    <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-align-left"></i>
                        <span>User</span></a>
                    <ul class={{ Request()->route()->named("mangeUsers") ? "collapse in" :"collapse" }}>
                        <li class={{ Request()->route()->named("mangeUsers") ? "active" :"" }}><a href="{{ route("mangeUsers") }}">Users</a></li>
                        <li class={{ Request()->route()->named("allRole") ? "active" :"" }}><a href="{{ route('allRole') }}">Role</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
