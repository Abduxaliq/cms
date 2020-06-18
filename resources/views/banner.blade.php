<link rel="stylesheet" href="https://www.novoye-vremya.com/css/jquery.bxslider.css">
<link rel="stylesheet" href="https://www.novoye-vremya.com/css/bxslider.style.css">
@if(isset($out))
    <script src="https://www.novoye-vremya.com/js/jquery-3.3.1.js" ></script>
@endif

<div class="bxslider_container">
    <ul class="bxslider">
        <li>
            @foreach($underSlider as $sn => $news)
            <div class="item">
                <div class="img">
                    <img alt="" src="https://www.novoye-vremya.com{{$helpers::getImageUrl($news->image,'medium')}}"/>
                </div>
                <div class="text">
                    <a target="_blank" href="https://www.novoye-vremya.com/posts/{{$news->slug}}">
                        {!! $news->title !!}<span style="color:#ff0000">{{$news->short_title}}</span>
                    </a>
                </div>
            </div>
            @if($sn == 1)
            <div style="clear: both;"></div>
        </li>
        <li>
        @endif
            @endforeach
            <div style="clear: both;"></div>
        </li>

    </ul>
</div>

<div class="informer-title">
    <a href="https://www.novoye-vremya.com" target="_blank">
        www.novoye-vremya.com
    </a>
</div>
<script src="https://www.novoye-vremya.com/js/jquery.bxslider.min.js"></script>
<script>
    $(document).ready(function () {
        $('ul.bxslider').bxSlider({
            pager: false,
            controls: false,
            auto: true
        });
    })
</script>

{{-- counters --}}
<div style="display: none;">
@include('counter')
</div>
