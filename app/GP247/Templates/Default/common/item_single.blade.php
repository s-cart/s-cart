@php
    $thumb = $item['thumb'] ?? '';
    $url = $item['url'] ?? '';
    $title = $item['title'] ?? '';
@endphp
<article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $url }}">
  <img src="{{ gp247_file($thumb) }}" alt="" width="370" height="239"></a>
  <h5 class="post-classic-title"><a href="{{ $url }}">{{ $title }}</a></h5>
</article>