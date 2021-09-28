  {{-- Categories tore --}}
  @php
    // isset $storeId if is layout_page is vendor_home or vendor_product_lis
      $vendorStoreId = isset($storeId) ? $storeId : config('app.storeId');
  @endphp
  @if (function_exists('sc_vendor_get_categories_front') &&  count(sc_vendor_get_categories_front($vendorStoreId)))
  <div class="aside-item col-sm-6 col-md-5 col-lg-12">
    <h6 class="aside-title">{{ sc_language_render('front.categories_store') }}</h6>
    <ul class="list-shop-filter">
      @foreach (sc_vendor_get_categories_front($vendorStoreId) as $category)
      <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->title }}</a></li>
      @endforeach
    </ul>
  </div>
  @endif
  {{-- //Categories tore --}}