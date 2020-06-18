@extends('frontend.layout.app')

@section('title')
    Самые свежие и последние новости Азербайджана и мира - Novoye-vremya.com
@endsection

@section('meta_tags')
    <meta itemprop="image" content="/frontend/assets/img/logo.jpg"/>
    <meta itemprop="thumbnailUrl" content="/frontend/assets/img/logo.jpg"/>
    <meta name="description" content="Самые свежие и последние новости Азербайджана и мира"/>
    <meta name="keywords" content="новая эпоха, политика, экономика, обшество, происшествие, аналитика, интервью, спорт, культура, наука и технология, религия, интересное, в мире, видео и фотографии, новости баку, Новости Азербайджана, Азербайджан, землетрясение в баку, азербайджан, новое время газета"/>
    <meta property="og:url" itemprop="url" content="https://novoye-vremya.com/" />
    <meta property="og:title" itemprop="name" content="Самые свежие и последние новости Азербайджана и мира" />
    <meta property="og:image" content="/frontend/assets/img/logo.jpg"/>
    <meta content="300" http-equiv="refresh" />
    <meta name="revisit-after" content="30 days" />
@endsection

@section('content')
    <div class="container p-0">
        <!-- slider area -->
        <div class="row m-0 pt-2 pb-2">
            <div class="col-6 col-sm-6 col-lg-6 pr-2 pl-0 pt-0 pb-0">
                <div id="carouselExampleIndicators" class="carousel slide h-100" style="height:485px!important;">
                    <ol class="carousel-indicators m-0 p-0">
                        @foreach($slider as $sn=>$slide)
                        @php
                            $first = !$sn ? " border-left-0 active ":"";
                        @endphp
                        <li data-target="#carouselExampleIndicators"
                            data-slide-to="{{$sn}}" class="p-2 text-center {{$first}}">{{($sn+1)}}</li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner h-100">
                        @foreach($slider as $sn=>$slide)
                        @php $first = !$sn ? " active ":""; @endphp
                            <div class="carousel-item h-100 {{$first}}">
                                <a href="/posts/{{$slide->slug}}">
                                    <img class="d-block w-100 h-100" src="{{$helpers::getImageUrl($slide->image)}}"
                                         alt="First slide">
                                    <div class="carousel-caption text-left p-2 m-0 w-100 bg1x1">
                                        <h3>{!! $slide->title !!} <span style="color:#ff0000">{{$slide->short_title}}</span></h3>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-6 m-0 p-0">
                <div class="row m-0 p-0">
                    <div class="col-6 col-sm-6 col-lg-6 m-0 p-0 pr-2">
                        @php $date = date('d-m-Y'); @endphp
                        <div class="list-style1-header"> НОВОСТИ <span class="date">{{$date}}</span></div>
                        <div class="list-style1-content">
                            @foreach($newsList as $sn=>$news)
                            <a href="/posts/{{$news->slug}}">
                                @if($date != date('d-m-Y',strtotime($news->date)))
                                    @php $date = date('d-m-Y',strtotime($news->date)); @endphp
                                    <div class="item-date">{{$date}}</div>
                                @endif
                                <div class="item">
                                    <span class="time">{{date('H:i',strtotime($news->date))}}</span>
                                    <span class="content">
                                        {!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span>
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <a href="/allnews"><div class="list-style1-footer text-center"> >> подробнее << </div></a>
                    </div>
                    <div class="col-6 col-sm-6 col-lg-6 m-0 p-0 pr-2">
                        <div class="list-style2-header"> АКТУАЛЬНО </div>
                        <div class="list-style2-content">
                            @foreach($newsActual as $sn=>$news)
                            <a href="/posts/{{$news->slug}}">
                                <div class="item row m-0">
                                    <img src="{{$helpers::getImageUrl($news->image,'small')}}"
                                         class="col-4 col-sm-4 col-lg-4 p-1 pt-0 pb-0">
                                    <p class="col-8 col-sm-8 col-lg-8 m-0 p-1">
                                        {!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span>
                                    </p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end slider area -->
        <!-- news list -->
        <div class="row m-0 mt-2 p-1 news-style3-container">
            @foreach($underSlider as $sn=>$news)
            <div class="col-3 m-0 p-1">
                <a href="/posts/{{$news->slug}}" class="news-style3">
                    <img src="{{$helpers::getImageUrl($news->image,'medium')}}">
                    <span class="content">{!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span></span>
                </a>
            </div>
            @endforeach
        </div>
        <!-- end news list -->
        <!-- content section -->
        <div class="row mt-2 m-0 p-0">
            <div class="col-9 col-sm-9 col-lg-9 m-0 p-0 pr-2">
                @foreach($centerPostsList as $i => $posts)
                    <!-- ads area -->
                    @if(isset($centerAds[$i]))
                    {!! $centerAds[$i]->script_text !!}
                    @endif
                    <!-- ads area -->
                    <!-- news list area -->
                    @if(count($posts) > 0)
                    <div class="row m-0 mt-2 mb-2 p-0 news-list-style1">
                        <div class="col-12 col-sm-12 col-lg-12 m-0 header">
                            {{$posts[0]->category_name}}
                            <a href="/category/{{$posts[0]->category_slug}}">
                                <span>подробнее <i class="fa fa-angle-double-right"></i></span>
                            </a>
                        </div>
                        @foreach($posts as $sn => $news)
                        <div class="col-3 col-sm-3 col-lg-3 m-0 p-1 mt-2">
                            <a href="/posts/{{$news->slug}}">
                                <div class="item">
                                    <div class="img"><img src="{{$helpers::getImageUrl($news->image,'medium')}}"></div>
                                    <div class="content">{!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span></div>
                                    <div class="time p-1">{{date('d-m-Y H:i',strtotime($news->date))}}</div>
                                </div>
                            </a>
                        </div>
                        @if($sn == 3)
                            @break
                        @endif
                        @endforeach
                    </div>
                    @endif
                    <!-- end news list area -->
                @endforeach
            </div>
            @include('frontend.right')
        </div>
        <!-- end content section -->
    </div>
@endsection

@section('css')
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#carouselExampleIndicators').carousel({
            pause: true,
            interval: 5000,
            ride:'carousel'
        });
    });
</script>
@endsection