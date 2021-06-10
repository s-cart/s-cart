<article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $blog->getUrl() }}">
  <img src="{{ sc_file($blog->getThumb()) }}" alt="" width="370" height="239"></a>
  <div class="post-classic-content">
    <div class="post-classic-time">
      <time datetime="{{ $blog->created_at }}">{{ $blog->created_at }}</time>
    </div>
    <h5 class="post-classic-title"><a href="{{ $blog->getUrl() }}">{{ $blog->title }}</a></h5>
    <p class="post-classic-text">
        {{ $blog->description }}
    </p>
  </div>
</article>