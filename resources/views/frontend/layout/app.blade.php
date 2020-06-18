<!doctype html>
<html lang="ru">
<head>
    <title>@yield('title')</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="ru">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" title="Самые свежие и последние новости Азербайджана и мира - Novoye-vremya.com" content="_4GSxGpD-sH_ILwAl7t1euWIhVd0WB6_RY8ywVrvxX4" />
    <meta name="robots" content="index,follow"/>

    <meta property="og:site_name" content="novoye-vremya.com"/>
    <meta property="og:type" content="website" />
    @yield('meta_tags')
	<meta name="author" content="novoye-vremya.com" />
	<meta name="copyright" content="https://novoye-vremya.com/" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/frontend/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/frontend/assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/frontend/assets/datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="/frontend/assets/css/style.css">
    <!-- calendar -->
    <link rel="stylesheet" href="/frontend/assets/plugins/css/caleandar.css">

    @yield('css')
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/frontend/assets/js/jquery-3.2.1.slim.min.js" ></script>
    <script src="/frontend/assets/js/jquery-3.2.1.min.js" ></script>
</head>
<body>
    <header class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-md-12">
                <div class="container nv-header">
                    <div class="row">
                        <img class="logo" src="/uploads/img/{{$settings->logo}}">

                        <form class="form" action="/search" method="POST">
                            {{ csrf_field() }}
                            <input type="text" placeholder="Search.." name="search">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>

                        <span id="time"> </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 p-0 nv-menu-row">
                <nav class="nav nv-menu container">
                    @foreach($menus as $sn => $menu)
                    @php
                        $url = '/';
                        $border=( $sn==0 )?"border-0":"";
                        if($menu['type'] == 1 && $sn > 0) {
                            $url = '/page/'.$menu['page']['slug'];
                        } else if($menu['type'] == 2 && $sn > 0) {
                            $url = '/category/'.$menu['category']['slug'];
                        }
                    @endphp
                        <a class="nav-link {{$border}}" href="{{$url}}">{{$menu->name}}</a>
                    @endforeach
                </nav>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="container-fluid m-0 p-0 mt-3">
        <div class="row m-0 p-0">
            <div class="col-12 p-0 nv-footer-menu-row">
                <nav class="nav nv-footer-menu container">
                    @foreach($menus as $sn => $menu)
                        @php
                            $url = '/';
                            $border=( $sn==0 )?"border-0":"";
                            if($menu['type'] == 1 && $sn > 0) {
                                $url = '/page/'.$menu['page']['slug'];
                            } else if($menu['type'] == 2 && $sn > 0) {
                                $url = '/category/'.$menu['category']['slug'];
                            }
                        @endphp
                        <a class="nav-link {{$border}}" href="{{$url}}">{{$menu->name}}</a>
                    @endforeach
                </nav>
            </div>
            <div class="col-12 col-sm-12 col-lg-12 m-0 p-0">
                <div class="container textarea">
                    <div class="row p-0">
                        <div class="col-4 col-sm-4 col-lg-4 m-0 p-2 text">
                            Главный редактор: Шакир Агаев <br>
                            Aдрес : {{$settings->address}} <br>
                            Телефон: {{$settings->phone1}},{{$settings->phone2}}
                        </div>
                        <div class="col-5 col-sm-5 col-lg-5 m-0 flogo">
                            <div class="row m-0 p-0">
                                <img src="/frontend/assets/img/f1logo.png" class="col-5">
                                <div class="col-5 col-md-5 col-lg-5">
                                    @include('counter')
                                </div>
                                <!-- <img src="/frontend/assets/img/f2logo.png" class="col-5"> -->
                            </div>
                        </div>
                        <div class="col-3 col-sm-3 col-lg-3 m-0 p-2 text">
                            Copyright © 2002 -  {{date('Y')}} Novoye Vremya. <br>
                            All Rights Reserved. Yeni Zaman
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="/frontend/assets/js/bootstrap.min.js"></script>
    <script src="/frontend/assets/datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- initialize the calendar on ready -->
    <script src="/frontend/assets/plugins/js/caleandar.js"></script>
    <script type="application/javascript">
        function myDateFunction(id) {
            var date = $("#" + id).data("date");
            location.href = "/calendar/" + date;
            return true;
        }

        $(document).ready(function () {
            $("#calendar").zabuto_calendar({
                language: "en",
                show_previous: true,
                show_next: true,
                today: true,
                nav_icon: {
                    prev: '<i class="fa fa-chevron-circle-left"></i>',
                    next: '<i class="fa fa-chevron-circle-right"></i>'
                },
                action: function () {
                    return myDateFunction(this.id);
                },
            });
        });
    </script>
    <!-- end calendar -->
    <script type="text/javascript">
        // google analytics
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '{{$settings->analystic}}']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
        // google analytics end

        setInterval(function() {
            var date = new Date(),
                day = (date.getDate() > 9)?date.getDate():'0'+date.getDate(),
                month = ((date.getMonth()+1) > 9)?(date.getMonth()+1):'0'+(date.getMonth()+1),
                fullYear = date.getFullYear(),
                hours = (date.getHours() > 9)?date.getHours():'0'+date.getHours(),
                min = (date.getMinutes() > 9)?date.getMinutes():'0'+date.getMinutes(),
                seconds = (date.getSeconds() > 9)?date.getSeconds():'0'+date.getSeconds();

            $('#time').html( day + " / " + month + " / " + fullYear + "  " + hours + ":" + min + ":" + seconds);
        }, 1000);

        $(function(){
            $('.news-list-style1 .content').css({
                'overflow': 'hidden' ,
                'line-height': '19px'
            });

            $('.news-list-style1 .content').each(function() {
                var text = $(this).text();
                $(this).attr('title', text);
            });

            $('#datepicker').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });
        });

        // $('#datepicker').change(function () {
        //     var date = $('#datepicker').val();
        //
        //     location.href = "/calendar/" + date;
        // });
    </script>
    @yield('js')
</body>
</html>