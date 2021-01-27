<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Stock Managerment </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="{{asset('css/vendor.css')}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('css/component-chosen.min.css')}}">
        @yield('css')
    </head>
    <body>
        <div class="main-wrapper">
            <div class="app" id="app">
                <header class="header">
                    <div class="header-block header-block-collapse d-lg-none d-xl-none">
                        <button class="collapse-btn" id="sidebar-collapse-btn">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <div class="header-block header-block-search">
                        @yield('header')
                    </div>
                    <div class="header-block header-block-buttons">


                    </div>
                    <div class="header-block header-block-nav">
                        <ul class="nav-profile">
                            <li class="notifications new">
                                <a href="" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <sup>
                                        <span class="counter">8</span>
                                    </sup>
                                </a>
                                <div class="dropdown-menu notifications-dropdown-menu">
                                    <ul class="notifications-container">
                                        <li>
                                            <a href="" class="notification-item">
                                                <div class="img-col">
                                                    <div class="img" style="background-image: url('assets/faces/3.jpg')"></div>
                                                </div>
                                                <div class="body-col">
                                                    <p>Lorem ipsum dolor sit amet.</p>                                                        <span class="accent">Zack Alien</span> pushed new commit: <span class="accent">Fix page load performance issue</span>. </p>
                                                </div>
                                            </a>
                                        </li>


                                    </ul>
                                    <footer>
                                        <ul>
                                            <li>
                                                <a href=""> View All </a>
                                            </li>
                                        </ul>
                                    </footer>
                                </div>
                            </li>
                            <li class="profile dropdown">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="img" style="background-image: url('{{asset(Auth::user()->photo)}}')">
                                    </div>
                                    <span class="name"> {{Auth::user()->name}} </span>
                                </a>
                                <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="#">
                                        <i class="fa fa-user icon"></i> Profile </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa fa-bell icon"></i> Notifications </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa fa-gear icon"></i> Settings </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{url('user/logout')}}">
                                        <i class="fa fa-power-off icon"></i> Logout </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </header>
                <aside class="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <div class="brand">
                                <div class="logo">
                                    <span class="l l1"></span>
                                    <span class="l l2"></span>
                                    <span class="l l3"></span>
                                    <span class="l l4"></span>
                                    <span class="l l5"></span>
                                </div> Stock Admin
                            </div>
                        </div>
                        <nav class="menu">
                            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                                <li >
                                    <a href="index.html">
                                        <i class="fa fa-home"></i> Dashboard </a>
                                </li>
                                <li id="menu_stock">
                                    <a href="">
                                        <i class="fa fa-bank"></i> Stock Operation <i class="fa arrow"></i>
                                    </a>
                                    <ul class="sidebar-nav" id="stock_collapse">
                                        <li id="menu_in">
                                            {{-- use url    --}}
                                            <a href="{{url('stock-in')}}"> <i class="fa fa-arrow-right"></i> Stock In</a>
                                            {{-- use route name <a href="{{route('stock-in.index')}}"> <i class="fa fa-arrow-right"></i> Categories</a> --}}
                                        </li>
                                        <li id="menu_out">
                                            <a href="{{url('stock-out')}}"> <i class="fa fa-arrow-right"></i> Stock Out</a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="menu_product">
                                    <a href="{{url('product')}}">
                                        <i class="fa fa-product-hunt"></i> Products </a>
                                </li>
                                <li id="menu_setting">
                                    <a href="">
                                        <i class="fa fa-cog"></i> Settings <i class="fa arrow"></i>
                                    </a>
                                    <ul class="sidebar-nav" id="setting_collapse">
                                        <li id="menu_category">
                                            {{-- use url    --}}
                                            <a href="{{url('category')}}"> <i class="fa fa-arrow-right"></i> Categories</a>
                                            {{-- use route name <a href="{{route('category.index')}}"> <i class="fa fa-arrow-right"></i> Categories</a> --}}
                                        </li>
                                        <li id="menu_warhouse">
                                            <a href="{{route('warehouse.index')}}"> <i class="fa fa-arrow-right"></i> Warhouse</a>
                                        </li>
                                        <li id="menu_unit">
                                            <a href="{{route('unit.index')}}"> <i class="fa fa-arrow-right"></i> Units</a>
                                        </li>
                                    </ul>
                                </li>
                                <li id="menu_security">
                                    <a href="">
                                        <i class="fa fa-lock"></i> Security <i class="fa arrow"></i>
                                    </a>
                                    <ul class="sidebar-nav" id="security_collapse">
                                        @canview('user')
                                            <li id="menu_user">
                                                <a href="{{url('user')}}"> <i class="fa fa-arrow-right"></i> Users</a>
                                            </li>
                                        @endcanview
                                            {{--  <li id="menu_role">
                                                <a href="{{url('role')}}"> <i class="fa fa-arrow-right"></i> Roles</a>
                                            </li>  --}}
                                        @canview('role')
                                            <li id="menu_role">
                                                <a href="{{url('role')}}"> <i class="fa fa-arrow-right"></i> Roles</a>
                                            </li>
                                        @endcanview
                                    </ul>
                                </li>


                            </ul>
                        </nav>
                    </div>
                    <footer class="sidebar-footer">
                        <ul class="sidebar-menu metismenu" id="customize-menu">

                        </ul>
                    </footer>
                </aside>
                <div class="sidebar-overlay" id="sidebar-overlay"></div>
                <div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
                <div class="mobile-menu-handle"></div>
                <article class="content dashboard-page">
                    <section class="section">
                        @yield('content')
                    </section>

                </article>
                <footer class="footer">
                    <div class="footer-block buttons">
                        Copy&copy; {{date('Y')}}
                    </div>
                    <div class="footer-block author">
                        <ul>
                            <li> created by <a href="https://github.com/socheadara">Sochea Dara</a>
                            </li>
                            <li>
                                <a href="#">hearamelody168@gmail.com</a>
                            </li>
                        </ul>
                    </div>
                </footer>

            </div>
        </div>
        <!-- Reference block for JS -->
        <div class="ref" id="ref">
            <div class="color-primary"></div>
            <div class="chart">
                <div class="color-primary"></div>
                <div class="color-secondary"></div>
            </div>
        </div>
        <script src="{{asset('js/vendor.js')}}"></script>
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/chosen.jquery.min.js')}}"></script>
        <script>
            $('.chosen-select').chosen();
        </script>
        @yield('js')
    </body>
</html>
