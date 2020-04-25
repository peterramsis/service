<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield("title")</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href='{{asset("/assets/en/bootstrap/css/bootstrap.min.css")}}'>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href='{{  asset("/assets/en/css/AdminLTE.min.css") }}'>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href='{{ asset("/assets/en/css/skins/_all-skins.min.css") }}'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Styles -->
    @yield("css")

</head>
<body>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">

          <header class="main-header">
            <!-- Logo -->
            <a href="index2.html" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini">{{ __("alt") }}</span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg">{{ __("admin_panal") }}</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">


                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="{{ asset('upload/user/').'/'.Sentinel::getUser()->image }}" class="user-image" alt="User Image">
                      <span class="hidden-xs">{{ Sentinel::getUser()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="{{ asset('upload/user/').'/'.Sentinel::getUser()->image }}" class="img-circle" alt="User Image">
                        <p>
                          {{ Sentinel::getUser()->name }}
                        </p>
                      </li>

                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">


                          <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                          onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                       </a>

                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                           @csrf
                       </form>
                        </div>
                      </li>
                    </ul>
                  </li>
                  <!-- Control Sidebar Toggle Button -->

                </ul>
              </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

              <!-- sidebar menu: : style can be found in sidebar.less -->
              <ul class="sidebar-menu">

                <li class="{{ request()->route()->named('admin') == 'true' ? 'treeview active' : 'treeview' }}">
                  <a href="{{ route("admin") }}">
                    <i class="fa fa-dashboard"></i> <span>{{ __("dashborad") }}</span> <i class="fa fa-angle-left pull-right"></i>
                  </a>

                </li>


                <li class="{{ request()->route()->named('mangeUsers') || request()->route()->named('allRole') == 'true' ? 'treeview active' : 'treeview' }}">
                    <a href="#">
                      <i class="fa fa-table"></i><i class="fa fa-share"></i> <span>{{ __("users") }}</span>
                      <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class="{{ request()->route()->named('mangeUsers')  == 'true' ? 'active' : ''  }}"><a href="{{ route('mangeUsers') }}"><i class="{{ request()->route()->named('mangeUsers')  == 'true' ? 'fa fa-circle' : 'fa fa-circle-o'  }}" ></i> {{ __('users') }}</a></li>
                      <li class="{{ request()->route()->named('allRole')  == 'true' ? 'active' : ''  }}"><a href="{{ route('allRole') }}"><i class="{{ request()->route()->named('allRole')  == 'true' ? 'fa fa-circle' : 'fa fa-circle-o'  }}" ></i> {{ __('roles') }}</a></li>
                    </ul>
                  </li>
            </section>
            <!-- /.sidebar -->
          </aside>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield("breadcrumb")

            <!-- Main content -->
            <section class="content">

                @yield("content")


            </section><!-- /.content -->
          </div><!-- /.content-wrapper -->

          <footer class="main-footer text-center">

            <strong>Copyright &copy; 2020
          </footer>


          <div class="control-sidebar-bg"></div>
        </div>

        <!-- jQuery 2.1.4 -->
        <script src="{{ asset('/assets/ar/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <!-- Bootstrap 3.3.4 -->
        <script src="{{ asset('/assets/ar/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset('/assets/ar/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('assets/ar/plugins/fastclick/fastclick.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('/assets/ar/js/app.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('/assets/ar/js/demo.js') }}"></script>


    @yield('js')
</body>
</html>
