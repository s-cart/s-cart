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
  <h5 class="mb-5 font-w-5">{{ trans('front.products_last_view') }}</h5>
  <div class="widget border-bottom mb-2">
    @foreach ($arrProductsLastView as $product_lastView)
      <div class="media align-items-center mb-4">
        <a class="d-block mr-1 ml-n4" href="{{$product_lastView->getUrl()}}">
          <img class="rounded" src="{{ asset($product_lastView->getThumb()) }}" alt="Product" width="75">
        </a>
        <div class="media-body">
          <div class="product-title">
            <a class="link-title small" href="{{$product_lastView->getUrl()}}">{{$product_lastView->name}}</a>
          </div>
          <span class="d-inline-block text-muted font-w-5" style="font-size: 65%;">{{$product_lastView['timelastview']}}</span>
        </div>
      </div>
    @endforeach
  </div>
@endif
</div> {{-- close tag shadow-sm p-5 --}}
