@include('vendor.upepo.admin.layouts.parts.header')
<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ url('admin/home') }}" class="site_title"><i class="panelIcon home"></i>
                    <span>Administrare</span>
                    </a>
                </div>
                <div class="clearfix"></div>
                <br>

            @include('vendor.decoweb.admin.layouts.parts.sidebar')

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a href="{{ url('/') }}" target="_blank" data-toggle="tooltip" data-placement="top"
                       title="Vezi site">
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                    </a>
                    <a href="{{ url('admin/settings') }}" data-toggle="tooltip" data-placement="top" title="Setari">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a href="{{ url('admin/home/account') }}" data-toggle="tooltip" data-placement="top" title="Profil">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                    <ul class=" navbar-right">
                        <li class="nav-item dropdown open" style="padding-left: 15px;">
                            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                               id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('assets/admin/images/admin.jpg') }}" alt="">{{ Auth::guard('admin')->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.account') }}"><i
                                        class="fa fa-user pull-right"></i> Profil</a>
                                <a class="dropdown-item" href="{{ route('admin.help') }}"><i
                                        class="fa fa-info pull-right"></i> Ajutor</a>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                        @if( config('shop.active') === true )
                            <li class="nav-item">
                                <a href="{{ url('admin/shop/orders') }}">
                                    @if( $newOrders != 0 )
                                        Aveti comenzi noi
                                        <i class="fa fa-bell-o animated swing infinite"></i>
                                        <span class="badge bg-green">{{ $newOrders }}</span>
                                    @else
                                        <i class="fa fa-bell-slash-o"></i>
                                    @endif
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
{{--            <div class="row" style="display: inline-block">bwertwertwertwer</div>--}}
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel tile">
                        <div class="x_title">
                            <h3>@yield('section-title','section-title')</h3>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if( ! defined('NOERRORS') )
                                @include('vendor.upepo.errors.errors')
                            @endif
                            @if(session()->has('mesaj'))
                                @include('vendor.upepo.admin.layouts.parts.messages')
                            @endif
                            @if(session()->has('aborted'))
                                @include('vendor.upepo.admin.layouts.parts.abortedMessage')
                            @endif
                            @yield('section-content','section-content to add...')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
@include('vendor.upepo.admin.layouts.parts.footer')
