@php
$banners = $modelBanner->start()->setType('banner')->getData()
@endphp
@if ($banners->count())
<section class="section swiper-container swiper-slider swiper-slider-1" data-loop="true" data-autoplay="5000">
  <div class="swiper-wrapper text-center text-lg-left">
    @foreach ($banners as $key => $banner)
    <div class="swiper-slide swiper-slide-caption context-dark" data-slide-bg="{{ sc_file($banner->image) }}">
      <div class="swiper-slide-caption section-md text-center">
        <div class="container">
          <a href="{{ sc_route('banner.click',['id' => $banner->id]) }}" target="{{ $banner->target }}">
            {!! sc_html_render($banner->html) !!}
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <!-- Swiper Pagination-->
  <div class="swiper-pagination"></div>
  <!-- Swiper Navigation-->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</section>
<!--slider-->
@endif