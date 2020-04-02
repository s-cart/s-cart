@php
$banners = $modelBanner->start()->getBanner()->getData()
@endphp
@if (!empty($banners))
<!--slider-->
<div class="container">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-3"></div>
    <div class="col-12 col-sm-12 col-md-12 col-lg-9">
      <div class=" slider-home">
        @foreach ($banners as $key => $banner)
        <div class="slider-home-item">
          <a href="{{ route('banner.click',['id' => $banner->id]) }}" target="{{ $banner->target }}">
            <img src="{{ asset($banner->image) }}" alt="">
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
<!--slider-->
@endif