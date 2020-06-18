<!DOCTYPE html>

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title> Azdesign.ws | Admin Panel </title>



    <!-- Bootstrap -->

    <link href="/backend/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="/backend/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- NProgress -->

    <link href="/backend/vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- iCheck -->

    <link href="/backend/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->

    <link href="/backend/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- JQVMap -->

    <link href="/backend/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>

    <!-- bootstrap-daterangepicker -->

    <link href="/backend/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">



    <!-- Custom Theme Style -->

    <link href="/backend/build/css/custom.min.css" rel="stylesheet">

    @yield('css')

</head>



<body class="nav-md">

<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">

            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">

                    <a href="/admin/" class="site_title"><i class="fa fa-newspaper-o"></i> <span> NV-ADMIN </span></a>

                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->

                <div class="profile clearfix">

                    <div class="profile_pic">

                        <img src="/backend/user-default.jpg" alt="..." class="img-circle profile_img">

                    </div>

                    <div class="profile_info">

                        <span>Xoş gəlmisiz,</span>

                        <h2>{{session('fullname')}}</h2>

                    </div>

                </div>

                <!-- /menu profile quick info -->



                <br />



                <!-- sidebar menu -->

                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">

                        <h3>Menu</h3>

                        <ul class="nav side-menu">

                            <li><a href="/admin/"><i class="fa fa-home"></i> Home </a></li>

                            <li><a href="/admin/settings"><i class="fa fa-cog"></i> Settings </a></li>

                            <li><a href="/admin/menus"><i class="fa fa-list"></i> Menus </a></li>

                            <li><a href="/admin/category"><i class="fa fa-list-alt"></i> Category </a></li>

                            <li><a href="/admin/position"><i class="fa fa-list-alt"></i> Position </a></li>

                            <li><a href="/admin/posts/{{date('Y-m-d')}}"><i class="fa fa-newspaper-o"></i> Posts </a></li>

                            <li><a href="/admin/page"><i class="fa fa-file"></i> Page </a></li>

                            <li><a href="/admin/ads"><i class="fa fa-file"></i> Advertising </a></li>

                            <li><a href="/admin/voting"><i class="fa fa-list"></i> Voting </a></li>

                            <li><a href="/admin/document"><i class="fa fa-file-pdf-o"></i> PDF </a></li>

                            {{--<li><a><i class="fa fa-cons"></i> Ana səhifə <span class="fa fa-chevron-down"></span></a>

                                <ul class="nav child_menu">

                                    <li><a href="/admin/">Ana səhifə</a></li>

                                </ul>

                            </li>--}}

                        </ul>

                    </div>



                </div>

                <!-- /sidebar menu -->

            </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">

            <div class="nav_menu">

                <nav>

                    <div class="nav toggle">

                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>

                    </div>



                    <ul class="nav navbar-nav navbar-right">

                        <li class="">

                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                <img src="/backend/user-default.jpg" alt="">{{session('fullname')}}

                                <span class=" fa fa-angle-down"></span>

                            </a>

                            <ul class="dropdown-menu dropdown-usermenu pull-right">

                                <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>

                            </ul>

                        </li>

                    </ul>

                </nav>

            </div>

        </div>

        <!-- /top navigation -->



        <!-- page content -->

        <div class="right_col" role="main">

            <div class="">

                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="x_panel">

                            <div class="x_title">

                                <h2>@yield('page_title')</h2>

                                <ul class="nav navbar-right panel_toolbox">

                                    @yield('buttons')

                                </ul>

                                <div class="clearfix"></div>

                            </div>

                            <div class="x_content">

                                @yield('content')

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

            <div class="pull-right">

                Created by <b><a href="http://www.azdesign.ws/site/" target="_blank">azdesign.ws</a></b>

            </div>

            <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

    </div>

</div>



<!-- jQuery -->

<script src="/backend/vendors/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap -->

<script src="/backend/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- FastClick -->

<script src="/backend/vendors/fastclick/lib/fastclick.js"></script>

<!-- NProgress -->

<script src="/backend/vendors/nprogress/nprogress.js"></script>

<!-- Chart.js -->

<script src="/backend/vendors/Chart.js/dist/Chart.min.js"></script>

<!-- gauge.js -->

<script src="/backend/vendors/gauge.js/dist/gauge.min.js"></script>

<!-- bootstrap-progressbar -->

<script src="/backend/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

<!-- iCheck -->

<script src="/backend/vendors/iCheck/icheck.min.js"></script>

<!-- Skycons -->

<script src="/backend/vendors/skycons/skycons.js"></script>

<!-- Flot -->

<script src="/backend/vendors/Flot/jquery.flot.js"></script>

<script src="/backend/vendors/Flot/jquery.flot.pie.js"></script>

<script src="/backend/vendors/Flot/jquery.flot.time.js"></script>

<script src="/backend/vendors/Flot/jquery.flot.stack.js"></script>

<script src="/backend/vendors/Flot/jquery.flot.resize.js"></script>

<!-- Flot plugins -->

<script src="/backend/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>

<script src="/backend/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>

<script src="/backend/vendors/flot.curvedlines/curvedLines.js"></script>

<!-- DateJS -->

<script src="/backend/vendors/DateJS/build/date.js"></script>

<!-- JQVMap -->

<script src="/backend/vendors/jqvmap/dist/jquery.vmap.js"></script>

<script src="/backend/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>

<script src="/backend/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

<!-- bootstrap-daterangepicker -->

<script src="/backend/vendors/moment/min/moment.min.js"></script>

<script src="/backend/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>



<!-- Custom Theme Scripts -->

<script src="/backend/build/js/custom.min.js"></script>

@yield('js')

</body>

</html>

