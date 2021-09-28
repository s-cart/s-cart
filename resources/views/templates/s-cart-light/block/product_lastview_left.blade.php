@php
$arrProductsLastView = array();
$lastView = empty(\Cookie::get('productsLastView')) ? [] : json_decode(\Cookie::get('productsLastView'), true);
if ($lastView) {
    arsort($lastView);
}

if ($lastView && count($lastView)) {
    $lastView = array_slice($lastView, 0, sc_config('product_viewed'), true);
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
<div class="aside-item col-sm-6 col-lg-12">
    <h6 class="aside-title">{{ sc_language_render('front.products_last_view') }}</h6>
    <!--last_view_product-->
    <div class="row row-20 row-lg-30 gutters-10">
        @foreach ($arrProductsLastView as $productLastView)
        <div class="col-4 col-lg-12">
            <!-- Post Minimal-->
            <article class="post post-minimal">
              <div class="unit unit-spacing-sm flex-column flex-lg-row align-items-lg-center">
                <div class="unit-left"><a class="post-minimal-figure" href="{{ $productLastView->getUrl() }}">
                    <img src="{{ sc_file($productLastView->getThumb()) }}" alt="" width="106" height="104"></a></div>
                <div class="unit-body">
                  <p class="post-minimal-title"><a href="{{ $productLastView->getUrl() }}">{{ $productLastView->name}}</a></p>
                  <div class="post-minimal-time">
                    <time datetime="{{ $productLastView['timelastview'] }}">{{ $productLastView['timelastview'] }}</time>
                  </div>
                </div>
              </div>
            </article>
          </div>
        @endforeach
    </div>
</div>
<!--/last_view_product-->
@endif
