@extends('frontend.layout.app')

@section('title')
    {{$categoryData->name}} - Novoye-vremya.com
@endsection

@section('meta_tags')
    <meta property="og:image" content="/frontend/assets/img/logo.jpg"/>
    <meta itemprop="image" content="/frontend/assets/img/logo.jpg"/>
    <meta itemprop="thumbnailUrl" content="/frontend/assets/img/logo.jpg"/>
    <meta name="description" content="Самые свежие и последние новости Азербайджана и мира"/>
    <meta name="keywords" content="Самые свежие и последние новости Азербайджана и мира"/>
    <meta property="og:site_name" content="novoye-vremya.com veb saytı"/>
@endsection

@section('content')
    <div class="container p-0">
        <!-- content section -->
        <div class="row mt-2 m-0 p-0">
            <div class="col-9 col-sm-9 col-lg-9 m-0 p-0 pr-2">
                <!-- news list area -->
                @if(count($categoryPostsList) > 0)
                <div class="row m-0 mt-2 mb-2 p-0 news-list-style1">
                    <div class="col-12 col-sm-12 col-lg-12 m-0 header">
                        {{$categoryData->name}}
                    </div>
                    @foreach($categoryPostsList as $news)
                    <div class="col-3 col-sm-3 col-lg-3 m-0 p-1 mt-2">
                        <a href="/posts/{{$news->slug}}">
                            <div class="item">
                                <div class="img"><img src="{{$helpers::getImageUrl($news->image,'medium')}}"></div>
                                <div class="content">{!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span></div>
                                <div class="time p-1">{{date('d-m-Y H:i',strtotime($news->date))}}</div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
                <!-- end news list area -->
                <br/>
                <div class="row">
                    <div class="col-md-8">
                        @if (method_exists($categoryPostsList,'links'))
                            {{ $categoryPostsList->links() }}
                        @endif
                    </div>
                </div>
            </div>
            @include('frontend.right')
        </div>
        <!-- end content section -->
    </div>
@endsection

@section('css')
@endsection

@section('js')
@endsection