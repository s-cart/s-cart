<article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $entry->getUrl() }}">
  <img src="{{ sc_file($entry->getThumb()) }}" alt="" width="370" height="239"></a>
  <div class="post-classic-content">
    <h5 class="post-classic-title"><a href="{{ $entry->getUrl() }}">{{ $entry->title }}</a></h5>
    <p class="post-classic-text">
        {{ $entry->description }}
    </p>
  </div>
</article>