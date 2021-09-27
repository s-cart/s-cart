  {{-- Categories tore --}}
  @if (function_exists('sc_vendor_get_categories_front') &&  count(sc_vendor_get_categories_front($storeId)))
  <div class="aside-item col-sm-6 col-md-5 col-lg-12">
    <h6 class="aside-title">{{ sc_language_render('front.categories_store') }}</h6>
    <ul class="list-shop-filter">
      @foreach (sc_vendor_get_categories_front($storeId) as $category)
      <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->title }}</a></li>
      @endforeach
    </ul>
  </div>
  @endif
  {{-- //Categories tore --}}