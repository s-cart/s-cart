@php
$arrProductsLastView = array();
$lastView = empty(\Cookie::get('productsLastView')) ? [] : json_decode(\Cookie::get('productsLastView'), true);
if ($lastView) {
    arsort($lastView);
}

if ($lastView && count($lastView)) {
    $lastView = array_slice($lastView, 0, 5, true);
    $productsLastView = $modelProduct->start()->getProductFromListID(array_keys($lastView))->getData();
    foreach ($lastView as $pId => $time) {
        foreach ($productsLastView as $key => $product) {
            if ($product['id'] == $pId) {
                $product['timelastview'] = $time;
                $arrProductsLastView[] = $product;
            }
        }
    }
}
@endphp

@if (!empty($arrProductsLastView))
            <div class="last_view_product"><!--last_view_product-->
              <h2>{{ trans('front.products_last_view') }}</h2>
              <div class="products-lasView">
                <ul class="nav nav-pills nav-stacked">
                  @foreach ($arrProductsLastView as $product_lastView)
                    <li>
                      <div class="row">
                        <div class="col-xs-4"><a href="{{ $product_lastView->getUrl() }}"><img src="{{ asset($product_lastView->getThumb()) }}" alt="{{ $product_lastView->name }}" /></a></div>
                        <div class="col-xs-8"><a href="{{ $product_lastView->getUrl() }}">{{ $product_lastView->name}}</a><span class="last-view">({{ $product_lastView['timelastview'] }})</span></div>
                      </div>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div><!--/last_view_product-->
@endif
