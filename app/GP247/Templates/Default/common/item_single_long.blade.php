@php
    $thumb = $item['thumb'] ?? '';
    $url = $item['url'] ?? '';
    $title = $item['title'] ?? '';
    $description = $item['description'] ?? '';
    $created_at = $item['created_at'] ?? '';
@endphp
<article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $url }}">
  <img src="{{ gp247_file($thumb) }}" alt="" width="370" height="239"></a>
  <div class="post-classic-content">
    <div class="post-classic-time">
      <time datetime="{{ $created_at }}">{{ $created_at }}</time>
    </div>
    <h5 class="post-classic-title"><a href="{{ $url }}">{{ $title }}</a></h5>
    <p class="post-classic-text">
        {{ $description }}
    </p>
  </div>
</article>