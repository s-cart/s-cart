<div class="product-price-wrap">
@switch($kind)
    @case(SC_PRODUCT_GROUP)
    <div class="product-price">{!! trans('product.price_group') !!}</div>
        @break
    @default
        @if ($price == $priceFinal)
            <div class="product-price">{!! sc_currency_render($price) !!}</div>
        @else
            <div class="product-price product-price-old">{!!  sc_currency_render($price) !!}</div>
            <div class="product-price">{!! sc_currency_render($priceFinal) !!}</div>
        @endif
@endswitch
</div>    