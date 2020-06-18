@extends('mobile.layout.app')

@section('title')
    Novoye Vremya Mobil versiya
@endsection

@section('meta_tags')
    <meta property="og:image" content="/frontend/assets/img/logo.jpg"/>
    <meta itemprop="image" content="/frontend/assets/img/logo.jpg"/>
    <meta name="robots" content="index,follow"/>
    <meta itemprop="thumbnailUrl" content="/frontend/assets/img/logo.jpg"/>
    <meta name="description" content="Самые свежие и последние новости Азербайджана и мира"/>
    <meta name="keywords" content="Самые свежие и последние новости Азербайджана и мира"/>
    <meta property="og:site_name" content="novoye-vremya.com"/>
@endsection

@section('content')
    <ul class="plist">
        @php $date = date('d-m-Y'); @endphp
        <div class="menu_basliq"> Лента новостей </div>
        @foreach($newsList as $news)

            @if($date != date('d-m-Y',strtotime($news->date)))
            <b>{{ date('d-m-Y',strtotime($news->date)) }}</b><br/>
            @endif

            <b> {{ date('H:i',strtotime($news->date)) }} </b>
            <div style="width: 100%; height: 50px; background-color:#eeeeee; margin-top:19px; margin-bottom: 15px;">
                <div style=" float: right; width: 93%; height: 50px;">
                    <h3 style="font-size: 15px;font-weight: 400;line-height: 18px;color: #000;">
                        <a href="/posts/{{ $news->slug }}">{!! $news->title !!} <span style="color:#ff0000"> {{$news->short_title}} </span></a>
                    </h3>
                </div>
            </div>
        @endforeach

        @foreach($centerPostsList as $posts)
            @if(count($posts) > 0)
            <div class="menu_basliq"> {{$posts[0]->category_name}} </div>
                @foreach($posts as $sn => $news)
                <div style="width: 100%; height: 100px; background-color:#eeeeee; margin-top:19px; margin-bottom: 15px;">
                    <div style="width: 35%; height: 100px; float: left; margin-top:-20px">
                        <a href="/posts/{{$news->slug}}">
                            <img src="{{$helpers::getImageUrl($news->image,'medium')}}" alt="" width="100%" height="100"  align="left"  />
                        </a>
                        <span class="date date-style-1">
                            <b>{{date('d-m-Y H:i',strtotime($news->date))}}</b>
                        </span>
                    </div>
                    <div style=" float: right; width: 63%; height: 100px;">
                        <h3 style="font-size: 15px;font-weight: 400;line-height: 18px;color: #000;">
                            <a href="/posts/{{$news->slug}}">{!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span></a>
                        </h3>
                    </div>
                </div>
                @endforeach
            @endif
        @endforeach
    </ul>
@endsection

@section('css')
<style>
    .menu_basliq{
        width: 100%;
        height: 25px;
        font-size: 25px;
        font-weight: bold;
        text-align: center;
        line-height: 25px;
        background-color:#ce0000;
        color: #fff;
        padding: 7px 0px;
        margin-top: -1px;
        font-family: Arial, Times new roman,serif;
    }

    .date-style-1 {
        float: left;
        margin-left: 7px;
        margin-top: -20px;
        width: 100px;
        background-color:#ce0000;
        color: #fff;
        size: 17px;
        padding: 5px;
        text-align: center;
    }
</style>
@endsection

@section('js')
@endsection