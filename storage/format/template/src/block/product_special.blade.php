@php
$productPromotion = $modelProduct->getProductPromotion()->setRandom()->setLimit(1)->getData()
@endphp

@if (!empty($productPromotion))
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
                      <img src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @endif
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
          </div><!--/product special-->
@endif
