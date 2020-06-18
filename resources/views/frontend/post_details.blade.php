@extends('frontend.layout.app')

@php 
    $my_title = strip_tags($postData->title . ' ' . $postData->short_title);
    $my_title = trim(str_replace(['&nbsp;','&amp;'], ['',''], $my_title));
@endphp

@section('title')
     {{ $my_title }} - Novoye-vremya.com
@endsection

@section('meta_tags')
    <meta property="fb:app_id" content="2899846393574166" />
    <meta name='description' itemprop='description' content='{{$postData->description}}'/>
    <meta name='keywords' content='{{$postData->tags}}'/>

    <meta property="og:description"  itemprop="description" content="{{$postData->description}}"/>
    <meta property="og:title" content="{{ $my_title }}"/>
    <meta property="og:url" itemprop="url" content="{{url()->current()}}"/>
    <meta property="og:locale" content="en-us"/>
    <meta property="og:locale:alternate" content="en-us"/>
    <meta property="og:site_name" content="{{$my_title}}"/>
    <meta property="og:image" content="https://novoye-vremya.com{{$helpers::getImageUrl($postData->image)}}"/>
    <meta property="og:image:url" content="https://novoye-vremya.com{{$helpers::getImageUrl($postData->image)}}"/>
    <meta property="og:image:alt" content="{{$postData->image}}"/>
    <meta property="og:image:width" content="700">
    <meta property="og:image:height" content="440">
    <meta property="og:type" itemprop="image" content="website" />
    <meta property="ia:markup_url" content="{{url()->current()}}"/>
    <meta property="ia:markup_url_dev" content="{{url()->current()}}"/>
    <meta property="ia:rules_url" content="{{url()->current()}}"/>
    <meta property="ia:rules_url_dev" content="{{url()->current()}}"/>
    <meta itemprop="inLanguage" content="ru" />
    <meta itemprop="datePublished" content="{{$postData->created_at}}" />
    <meta itemprop="dateModified" content="{{$postData->created_at}}" />

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="{{$my_title}}"/>
    <meta name="twitter:site" content="@novoye-vremya.com"/>
@endsection

@section('content')
    <div class="container p-0">
        <!-- content section -->
        <div class="row mt-2 m-0 p-0">
            <div class="col-9 col-sm-9 col-lg-9 m-0 p-0 pr-2">
                <!-- news list area -->
                <div class="row m-0 mt-2 p-0 news-list-style1">
                    <h1 class="col-12 col-sm-12 col-lg-12 m-0 mb-3 post-header">
                        {!! $postData->title !!} <span style="color:#ff0000"> {{$postData->short_title}} </span>
                    </h1>

                    <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 header">
                        <div class="post-date">{{date('d-m-Y H:i', strtotime($postData->date))}}</div>
                        <div class="post-view">Просмотров: {{number_format($postData->views)}}</div>
                        <div class="post-sosial">
                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                <a class="addthis_button_preferred_1"></a>
                                <a class="addthis_button_preferred_2"></a>
                                <a class="addthis_button_preferred_3"></a>
                                <a class="addthis_button_preferred_4"></a>
                                <a class="addthis_button_compact"></a>
                                <a class="addthis_counter addthis_bubble_style"></a>
                            </div>
                            <!-- AddThis Button END -->
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-lg-12 m-0 p-1 mt-2">
                        <div class="post-content">
                            <img src="{{$helpers::getImageUrl($postData->image)}}" style="width: 534px!important;">
                            {!! $postData->content !!}.
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-lg-12 m-0 p-1 mt-2">
                        @foreach($postImages as $image)
                            @if($postData->image !== $image->url)
                                <a class="fancybox" data-fancybox-group="gallery"
                                   href="{{$helpers::getImageUrl($image->url)}}">
                                    <img src="{{$helpers::getImageUrl($image->url, 'medium')}}" alt="{{$image->url}}"/>
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-12 col-sm-12 col-lg-12 m-0 p-1 mt-2">
                        <ul class="post-tags">
                            @foreach(explode(',', $postData->tags) as $item)
                                @if(!empty($item))
                                <li><a href="{{--/tags/{{$item}}--}}">#{{$item}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- end news list area -->
                @foreach($postAds as $ads)
                    <!-- ads area -->
                    @if(isset($ads))
                        {!! $ads->script_text !!}
                    @endif
                    <!-- ads area -->
                @endforeach
            </div>
            @include('frontend.right')
        </div>
        <!-- end content section -->
    </div>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/js/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5"/>
    <link rel="stylesheet" type="text/css" href="/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7"/>
    <style>
        .fancybox {
            width: 100% !important;
        }

        .post-header {
            font: bold 26px/30px Arial;
            padding: 0;
        }

        .post-date {
            font: 16px/32px Arial;
            color: #565656;
            float: left;
            width: 40%;
        }

        .post-view {
            font: 15px/32px Arial;
            color: #565656;
            float: left;
            width: 30%;
        }

        .post-sosial {
            float: left;
            width: 30%;
        }

        .post-content {
            font: 16px/21px Arial;
            text-align: justify;
            color: #2c2c2c;
        }

        .post-content img {
            float: left;
            padding: 0px 10px 5px 0px;
            width: 100%;
        }

        .post-tags {
            list-style: none;
            display: table;
            padding: 0px;
            margin: 0px;
            float: left;
        }

        .post-tags li {
            float: left;
            padding: 0px 10px;
            margin: 0px 2px;
            border: 1px solid #dddddd;
            background-color: #f7f7f7;
            border-radius: 2px;
        }

        .post-tags li a {
            text-decoration: none;
            color: #2c2c2c;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e6da0ad70be0ad8"></script>
    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="/js/fancybox/lib/jquery.mousewheel.pack.js?v=3.1.3"></script>
    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <!-- Add Button helper (this is optional) -->
    <script type="text/javascript" src="/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <!-- Add Thumbnail helper (this is optional) -->
    <script type="text/javascript" src="/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-5188032473425113",
            enable_page_level_ads: true
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.fancybox').fancybox();
        });
    </script>
@endsection