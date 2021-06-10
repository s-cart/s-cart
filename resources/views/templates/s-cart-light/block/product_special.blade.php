@php
$productPromotion = $modelProduct->getProductPromotion()->setRandom()->setLimit(sc_config('product_viewed'))->getData()
@endphp
@if (!empty($productPromotion))

<div class="aside-item col-sm-6 col-lg-12">
  <h6 class="aside-title">{{ sc_language_render('front.products_special') }}</h6>
  <div class="row row-10 row-lg-20 gutters-10">
    @foreach ($productPromotion as $key => $product)
    <div class="col-4 col-sm-6 col-md-12">
      {{-- Render product single --}}
      @include($sc_templatePath.'.common.product_single', ['product' => $product])
      {{-- //Render product single --}}
    </div>
    @endforeach
  </div>
</div>
<!--/product special-->
@endif