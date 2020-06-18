<div class="col-3 col-sm-3 col-lg-3">
    @if(!isset($showNewsList))
    <div class="row m-0 p-0">
        <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 pt-2 pb-2">
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
    </div>
    @endif
    <!-- ads area -->
    @if(isset($rightAds))
        {!! $rightAds->script_text !!}
    @endif
    <!-- ads area -->
    <!-- news list -->
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header">
            TOP 5
        </div>
        <div class="col-12 col-sm-12 col-lg-12 m-0 p-0">
            @foreach($top5 as $item)
            <a href="/posts/{{$item->slug}}">
                <div class="list p-2 mb-2">{!! $item->title !!} <span style="color:#ff0000">{{$item->short_title}}</span></div>
            </a>
            @endforeach
        </div>
    </div>
    @foreach($rightPostsList as $posts)
        @if(count($posts) > 0)
        <div class="row m-0 mt-4 p-0 news-list-style2">
            <a href="/category/{{$posts[0]->category_slug}}" style="width:100%;">
                <div class="col-12 col-sm-12 col-lg-12 m-0 header">{{$posts[0]->category_name}}</div>
            </a>
            <a href="/posts/{{$posts[0]->slug}}">
                <div class="col-12 col-sm-12 col-lg-12 m-0 p-0">
                    <img src="{{$helpers::getImageUrl($posts[0]->image,'medium')}}">
                    <div class="content p-2">{!! $posts[0]->title !!} <span style="color:#ff0000">{{$posts[0]->short_title}}</span></div>
                </div>
            </a>
        </div>
        @endif
    @endforeach
    <!-- end news list -->
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header"> PDF </div>
        <a href="#">
            <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 pt-1">
                <img src="/uploads/img/pdf_default.jpg" width="100%">
            </div>
            <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 pt-1">
                @foreach($pdfList as $pdf)
                <a href="/documents/{{$pdf->path}}" target="_blank">{{ $pdf->name }}</a>
                @endforeach
            </div>
        </a>
    </div>
    @if($votingCheck)
    <!-- end news list -->
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header"> SƏSVERMƏ </div>
        <iframe src="/voting" class="w-100" scrolling="no" frameborder="0" onload="resizeIframe(this)" > </iframe>
        <script>
            function resizeIframe(obj) {
                obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
            }
        </script>
    </div>
    @endif
    <!-- end news list -->
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header"> KIVDF </div>
        <a href="/category/kivdf-1906020408">
            <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 pt-1">
                <img src="/uploads/img/kivdf.jpg" width="100%">
            </div>
        </a>
    </div>
    <!-- calendar -->
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header"> КАЛЕНДАРЬ </div>
        <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 mt-2" id="calendar"></div>
    </div>
    <!-- end calendar -->
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header"> Oбмен </div>
        <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 pt-1">
            <!-- Investaz.az -->
            <script type="text/javascript">
                var iazw_converter = {
                    "width":260,"lang":"az","id":"iazw_converter_tool",
                    "css":{"hfc":"rgba(106,110,116,1)","hbgc":"rgba(236,239,241,1)","bbgc":"rgba(243,245,246,1)"},
                    "theme":"","from":"USD","to":"AZN"};
            </script>
            <a href="https://www.investaz.az" target="_blank" id="iazw_converter_tool" rel="nofollow">InvestAZ</a>
            <script type="text/javascript" src="//static.investaz.net/embed/tools/js/iazw-cur_converter.js"></script>
            <!-- / Investaz.az -->
        </div>
    </div>
    <div class="row m-0 mt-4 p-0 news-list-style2">
        <div class="col-12 col-sm-12 col-lg-12 m-0 header"> Neft </div>
        <div class="col-12 col-sm-12 col-lg-12 m-0 p-0 pt-1">
            <script type="text/javascript" src="https://www.oil-price.net/TABLE2/gen.php?lang=en"></script>
            <noscript>
                To get the WTI <a href="https://www.oil-price.net/dashboard.php?lang=en#TABLE2">oil price</a>,
                please enable Javascript.
            </noscript>
            <br/>
            <script type="text/javascript" src="https://www.oil-price.net/widgets/brent_crude_price_large/gen.php?lang=en">
            </script>
            <noscript>
                To get the BRENT <a href="https://www.oil-price.net/dashboard.php?lang=en#brent_crude_price_large">oil price</a>,
                please enable Javascript.
            </noscript>
        </div>
        <style>
            .oilpricenettable2 {
                width: 100% !important;
            }
        </style>
    </div>
</div>
