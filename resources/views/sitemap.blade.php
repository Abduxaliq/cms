<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @php $dateTime = new DateTime(); @endphp
    @foreach($categories as $category)
    <url>
        <loc>{{ url("/") }}/category/{{ $category->slug }}</loc>
        <lastmod>{{ $dateTime->format('Y-m-d\TH:i:sP') }}</lastmod>
        <changefreq>hourly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    @foreach($posts as $news)
        @php $dateTime2 = new DateTime($news->date); @endphp
    <url>
        <loc>{{ url("/") }}/posts/{{ $news->slug }}</loc>
        <lastmod>{{ $dateTime2->format('Y-m-d\TH:i:sP') }}</lastmod>
        <changefreq>always</changefreq>
        <priority>0.5</priority>
    </url>
    @endforeach
</urlset>
