@extends('mobile.layout.app')

@section('title')
    {{ strip_tags($postData->title . ' ' . $postData->short_title) }} - Novoye Vremya Mobil versiya
@endsection

@section('meta_tags')
    <meta name='description' itemprop='description' content='{{$postData->description}}'/>
    <meta name='keywords' content='{{$postData->tags}}'/>
    <meta property='article:published_time' content='{{$postData->created_at}}'/>

    <meta property="og:description" content="{{$postData->description}}"/>
    <meta property="og:title" content="{{ strip_tags($postData->title . ' ' . $postData->short_title) }}"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:locale" content="en-us"/>
    <meta property="og:locale:alternate" content="en-us"/>
    <meta property="og:site_name" content="{{ strip_tags($postData->title . ' ' . $postData->short_title) }}"/>
    <meta property="og:image" content="{{$helpers::getImageUrl($postData->image)}}"/>
    <meta property="og:image:url" content="{{$helpers::getImageUrl($postData->image)}}"/>
    <meta property="og:image:size" content="300"/>

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:title" content="{{ strip_tags($postData->title . ' ' . $postData->short_title) }}"/>
    <meta name="twitter:site" content="@novoye-vremya.com"/>
@endsection

@section('content')
    <!-- BACK  -->
    <div class="backbtn"><a href="javascript:history.go(-1)" class="btn3">&larr; НАЗАД</a></div>

    <h1>{!! $postData->title !!} <span style="color:#ff0000"> {{$postData->short_title}} </span></h1>
    <img src="{{$helpers::getImageUrl($postData->image)}}" width="97%" />
    <div class="cnt-img">{!! $postData->content !!}</div>
    <p>
        @foreach($postImages as $image)
            @if($postData->image !== $image->url)
                <img src="{{$helpers::getImageUrl($image->url, 'medium')}}" alt="{{$image->url}}" class="tmbrl" />
            @endif
        @endforeach
    </p>
    <p class="date arial" style="font-size: 10px;">Просмотров: {{ number_format($postData->views) }}</p>
    <p class="date arial" style="font-size: 10px;">Создано {{date('d-m-Y H:i', strtotime($postData->date))}}</p>

    <!-- AddThis Button BEGIN  -->
    <p>
        <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
        </div>
    </p>
@endsection

@section('css')
    <style>
        .cnt-img img, .tmbrl {
            width: 97% !important;
            padding: 10px !important;;
        }

        iframe {
            width:100%!important;
        }
    </style>
@endsection

@section('js')
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=rovsan"></script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-3556224187871159",
        enable_page_level_ads: true
    });
</script>
@endsection