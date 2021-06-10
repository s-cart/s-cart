@php
$news = $modelNews->start()->setlimit(sc_config('item_top'))->getData();
@endphp

@if ($news)
<!-- START SECTION NEWS -->
  <section class="section section-xxl section-last bg-gray-21">
    <div class="container">
      <h2 class="wow fadeScale">{{ sc_language_render('front.blog') }}</h2>
    </div>
    <!-- Owl Carousel-->
    <div class="owl-carousel owl-style-7" data-items="1" data-sm-items="2" data-xl-items="3" data-xxl-items="4" data-nav="true" data-dots="true" data-margin="30" data-autoplay="true">
      @foreach ($news as $blog)
        {{-- Render product single --}}
        @include($sc_templatePath.'.common.blog_single', ['blog' => $blog])
        {{-- //Render product single --}}
      @endforeach
    </div>
  </section>
<!-- END SECTION NEWS -->
@endif