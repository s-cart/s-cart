@php
  $productPromotion = $modelProduct->getProductPromotion()->setRandom()->setLimit(1)->getData()
@endphp

@if (!empty($productPromotion))
  <div class="card product-card">
    <h4 class="widget-title mb-3">{{trans('front.products_special')}}</h4>
    <button class="btn-wishlist btn-sm mt-3" type="button" data-toggle="tooltip" data-placement="left" title="" data-original-title="Add to wishlist">
      <i class="lar la-heart"></i>
    </button>
    @foreach ($productPromotion as $key => $product)
      <a class="card-img-hover d-block" href="{{$product->getUrl()}}">
        <img class="card-img-top card-img-back" src="{{asset($product->getThumb())}}" alt="...">
        <img class="card-img-top card-img-front" src="{{asset($product->getThumb())}}" alt="...">
        @if ($product->price != $product->getFinalPrice())
          <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
        @endif
      </a>
      
      <div class="card-info">
        <div class="card-body">
          <div class="product-title">
            <a class="link-title" href="{{$product->getUrl()}}">{{$product->name}}</a>
          </div>
          <div class="mt-1"> 
            <span class="product-price"> {!!$product->showPrice()!!}</span>
            <div class="star-rating">
              <i class="las la-star"></i>
              <i class="las la-star"></i>
              <i class="las la-star"></i>
              <i class="las la-star"></i>
              <i class="las la-star"></i>
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-0">
          <div class="product-link d-flex align-items-center justify-content-center">
            <button class="btn btn-compare" data-toggle="tooltip" data-placement="top" title="" type="button" data-original-title="Compare">
              <i class="las la-random"></i> 
            </button>
            <button class="btn-cart btn btn-primary btn-animated mx-3" type="button">
              <i class="las la-cart-plus mr-1"></i>
            </button>
            <button class="btn btn-view" data-toggle="tooltip" data-placement="top" title="" data-original-title="Quick View">
              <span data-target="#quick-view" data-toggle="modal">
                <i class="las la-eye"></i>
              </span>
            </button>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif


{{--@if (!empty($productPromotion))
          <div class="brands_products"><!--product special-->
            <h2>{{ trans('front.products_special') }}</h2>
            <div class="products-name">
              <ul class="nav nav-pills nav-stacked">
                @foreach ($productPromotion as $key => $product)
                  <li>
                    <div class="product-image-wrapper product-single">
                      <div class="single-products product-box-{{ $key }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product->getUrl() }}"><img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" /></a>
                            {!! $product->showPrice() !!}
                            <a href="{{ $product->getUrl() }}"><p>{{ $product->name }}</p></a>
                          </div>
                          @if ($product->price != $product->getFinalPrice())
                          <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                          @endif
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          </div><!--/product special-->
@endif--}}
