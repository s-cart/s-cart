@php
  $banners = $modelBanner->start()->getBanner()->getData()
@endphp

<!--hero section start-->
@if (!empty($banners))

<section class="banner pos-r p-0">
  <div class="banner-slider owl-carousel no-pb owl-2" data-dots="false" data-nav="true">
    @foreach ($banners as $key => $banner)
    <div class="item bg-pos-rt" data-bg-img="{{ asset($banner->image) }}">
        <div class="container h-100">
          <div class="row h-100 align-items-center">
            <div class="col-lg-7 col-md-12 custom-py-1 position-relative z-index-1">
              <h6 class="font-w-6 text-primary animated3">Welcome Ekocart</h6>
              <h1 class="mb-4 animated3">A New Online<br> Shop experience</h1>
              <div class="animated3">
                <a class="btn btn-primary btn-animated" target="{{$banner->target}}" href="{{ route('banner.click',['id' => $banner->id]) }}">Shop Now</a>
              </div>
              <div class="hero-circle animated4"></div>
            </div>
          </div>
        </div>
    </div>
    @endforeach
  </div>
</section>
@endif

<!--hero section end--> 

<!--body content start-->

  <!--feature start-->
  
  <section class="pb-0">
    <div class="container">
      <!-- / .row -->
      <div class="row">
        <div class="col-lg-3 col-sm-6">
          <div class="d-flex">
            <div class="mr-2">
              <i class="las la-truck ic-2x text-primary"></i>
            </div>
            <div>
              <h5 class="mb-1">Free Shipping</h5>
              <p class="mb-0">Writing result-oriented</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt-3 mt-sm-0">
          <div class="d-flex">
            <div class="mr-2">
              <i class="las la-hand-holding-usd ic-2x text-primary"></i>
            </div>
            <div>
              <h5 class="mb-1">Money Return</h5>
              <p class="mb-0">Writing result-oriented</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt-3 mt-lg-0">
          <div class="d-flex">
            <div class="mr-2">
              <i class="las la-lock ic-2x text-primary"></i>
            </div>
            <div>
              <h5 class="mb-1">Secure Payment</h5>
              <p class="mb-0">Writing result-oriented</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-sm-6 mt-3 mt-lg-0">
          <div class="d-flex">
            <div class="mr-2">
              <i class="las la-headset ic-2x text-primary"></i>
            </div>
            <div>
              <h5 class="mb-1">24/7 Support</h5>
              <p class="mb-0">Writing result-oriented</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  