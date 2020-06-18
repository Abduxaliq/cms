<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="google-site-verification" content="_4GSxGpD-sH_ILwAl7t1euWIhVd0WB6_RY8ywVrvxX4" />
    <title>@yield('title')</title>

    @yield('meta_tags')

    <link rel="stylesheet" href="/mobile/css/style1.css" />
    <link rel="stylesheet" type="text/css" href="/mobile/css/retinastyle1.css" media="only screen and (-webkit-min-device-pixel-ratio: 2)"/>
    <style type="text/css">
        body {
            padding: 0;
            margin: 0;
            font-family: Georgia,times new roman,Times,serif;
            font-size: 18px;
            line-height: 150%;
            background-color: #6a0000;
            background-size: 100%;
            color: #20201f;
        }
    </style>
    @yield('css')

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="/mobile/js/functions.js"></script>
</head>
<body style="background-color: #6a0000" >
<a name="top"></a>
<div id="main">
    <div id="header"  style="background-color: #6a0000; height:100px">
        <a href="/">
            <center>
                <img src="/mobile/images/logo18.png"  style="margin-top: 1px; width: 200px;"  />
            </center>
        </a>
    </div>

    <div id="header"  style="background-color: #ce0000; margin-top: -9px;height:38px">
        <center>
            <a href="" class="center" id="menubtn1" style="font: 20px/40px Arial,serif; text-decoration:none;color: #fff">
                <span> > > МEHЮ < < </span>
            </a>
        </center>
    </div>
    <div id="content" width="100%;">
        <div class="menu" id="menu1">
            <ul class="menuitems">
                @foreach($menus as $sn => $menu)
                    @php
                        $url = '/';
                        if($menu['type'] == 1 && $sn > 0) {
                            $url = '/page/'.$menu['page']['slug'];
                        } else if($menu['type'] == 2 && $sn > 0) {
                            $url = '/category/'.$menu['category']['slug'];
                        }
                    @endphp
                    <li><a href="{{$url}}"><span><span>{{$menu->name}}</span></span></a></li>
                @endforeach
                <li class="menuclose"><a href="#"><span><span>Close</span></span></a></li>
            </ul>
        </div>
        <!-- anons -->

        <div style="background-color: #f6f6f6; height: 70px; width: 100%;">
            @foreach($pdfList as $sn => $pdf)
                <a href="/documents/{{$pdf->path}}"><img src="/mobile/images/pdf/{{ ($sn+1) }}.png" width="36px"></a>
            @endforeach
        </div>

        @yield('content')
    </div>

    <!-- FOOTER -->
    <div id="footer" >
        <em class="left" style="color:#000;font-size:13px;line-height:17px;font-family:Tahoma, Geneva, sans-serif;">
            <a  style="cursor:pointer; font-size:13px;line-height:17px;font-family:Tahoma, Geneva, sans-serif;">
                Copyright (c) Novoye Nremya Mobil versiya 2018 Mobil versiya
            </a>
        </em><br/>
        <a href="/web/desktop" class="web" style="font:13px/17px Tahoma, Geneva, sans-serif; color: #fff; list-style: none;">
            Saytin tam versiyasi
        </a> <br/>

        <span style="cursor:pointer; font-size:13px;line-height:17px;font-family:Tahoma, Geneva, sans-serif;">
            Главный редактор: Шакир Агаев  <br>
            Aдрес : {{$settings->address}} <br>
            Телефон: {{$settings->phone1}},{{$settings->phone2}} <br>
            E-mail: shakir@yandex.ru; musa-u@yandex.ru <br>
        </span>

    </div>
</div>
<script>
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
</script>
@include('counter')
@yield('js')
</body>
</html>