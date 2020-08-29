@php
$productPromotion = $modelProduct->getProductPromotion()->setRandom()->setLimit(sc_config('product_viewed'))->getData()
@endphp
@if (!empty($productPromotion))

<div class="aside-item col-sm-6 col-lg-12">
  <h6 class="aside-title">{{ trans('front.products_special') }}</h6>
  <div class="row row-10 row-lg-20 gutters-10">
    @foreach ($productPromotion as $key => $product)
    <div class="col-4 col-sm-6 col-md-12">
      <!-- Product Minimal-->
      <article class="product-minimal">
        <div class="unit unit-spacing-sm flex-column flex-md-row align-items-center">
          <div class="unit-left">
            <a class="post-minimal-figure" href="{{ $product->getUrl() }}">
            <img src="{{ asset($product->getThumb()) }}" alt="" width="106" height="104">
            </a>
          </div>
          <div class="unit-body">
            <p class="product-minimal-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></p>
            <p class="product-minimal-price">
              {!! $product->showPrice() !!}
            </p>
          </div>
        </div>
      </article>
    </div>
    @endforeach
  </div>
</div>
<!--/product special-->
@endif