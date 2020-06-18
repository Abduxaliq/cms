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
        @if(count($categoryPostsList) > 0)
            @foreach($categoryPostsList as $news)
                    <p>
                        <a href="/posts/{{$news->slug}}">
                            <img src="{{$helpers::getImageUrl($news->image,'medium')}}" alt="" width="100%"/>
                        </a>
                    </p>
                    <h1>
                        <a href="/posts/{{$news->slug}}">{!! $news->title !!} <span style="color:#ff0000">{{$news->short_title}}</span></a>
                    </h1>
                    <p> <span class="date">{{ date('d-m-Y H:i',strtotime($news->date)) }}</span></p>
                @endforeach
        @endif
    </ul>

    <!--  BUTTONS -->
    <div class="pages">
        {{ $categoryPostsList->links() }}
    </div>
@endsection

@section('css')
@endsection

@section('js')
@endsection