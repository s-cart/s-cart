@php
/*
$layout_page = shop_home
**Variables:**
- $products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/ 
@endphp

@extends($sc_templatePath.'.layout')

{{-- block_main_content_center --}}
@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">
  
  {{-- Sort filter --}}
  <div class="product-top-panel group-md">
    <p class="product-top-panel-title">
      {!! sc_language_render('front.result_item', ['item_from' => $products->firstItem(), 'item_to'=> $products->lastItem(), 'total'=> $products->total()  ]) !!}
    </p>
        <form action="" method="GET" id="filter_sort">
          @php
          $queries = request()->except(['filter_sort','page']);
          @endphp
          @foreach ($queries as $key => $query)
          <input type="hidden" name="{{ $key }}" value="{{ $query }}">
          @endforeach
          
          <select class="form-control" name="filter_sort">
              <option value="">{{ sc_language_render('action.sort') }}</option>
              <option value="price_asc" {{ ($filter_sort =='price_asc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.price_asc') }}</option>
              <option value="price_desc" {{ ($filter_sort =='price_desc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.price_desc') }}</option>
              <option value="sort_asc" {{ ($filter_sort =='sort_asc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.sort_asc') }}</option>
              <option value="sort_desc" {{ ($filter_sort =='sort_desc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.sort_desc') }}</option>
              <option value="id_asc" {{ ($filter_sort =='id_asc')?'selected':'' }}>
                {{ sc_language_render('filter_sort.id_asc') }}
              </option>
              <option value="id_desc" {{ ($filter_sort =='id_desc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.id_desc') }}</option>
          </select>
        </form>
  </div>
  {{-- //Sort filter --}}

  {{-- Product list --}}
  <div class="row row-30 row-lg-50">
    @foreach ($products as $key => $product)
    <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
        <!-- Product-->
        <article class="product wow fadeInRight">
          <div class="product-body">
            <div class="product-figure">
                <a href="{{ $product->getUrl() }}">
                <img src="{{ sc_file($product->getThumb()) }}" alt="{{ $product->name }}"/>
                </a>
            </div>
            <h5 class="product-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></h5>

            {{-- Go to store --}}
            @if (sc_config_global('MultiVendorPro') && config('app.storeId') == SC_ID_ROOT)
            <div class="store-url"><a href="{{ $product->goToStore() }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> {{ sc_language_render('front.store').' '. $product->store_id  }}</a>
            </div>
            @endif
            {{-- End go to store --}}

            @if ($product->allowSale())
            <a onClick="addToCartAjax('{{ $product->id }}','default','{{ $product->store_id }}')" class="button button-lg button-secondary button-zakaria add-to-cart-list">
              <i class="fa fa-cart-plus"></i> {{sc_language_render('action.add_to_cart')}}</a>
            @endif

            {!! $product->showPrice() !!}
          </div>
          
          @if ($product->price != $product->getFinalPrice() && $product->kind !=
          SC_PRODUCT_GROUP)
          <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
          @elseif($product->kind == SC_PRODUCT_BUILD)
          <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
          @elseif($product->kind == SC_PRODUCT_GROUP)
          <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
          @endif
          <div class="product-button-wrap">
            <div class="product-button">
                <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','wishlist','{{ $product->store_id }}')">
                    <i class="fas fa-heart"></i>
                </a>
            </div>
            <div class="product-button">
                <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','compare','{{ $product->store_id }}')">
                    <i class="fa fa-exchange"></i>
                </a>
            </div>
          </div>
        </article>
      </div>
    @endforeach
  </div>

  <div class="pagination-wrap">
    <!-- Bootstrap Pagination-->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        {{ $products->appends(request()->except(['page','_token']))->links() }}
      </ul>
    </nav>
  </div>
  {{-- //Product list --}}
@endsection
{{-- //block_main_content_center --}}


@section('blockStoreLeft')
{{-- Categories tore --}}
{{-- Only show category store if shop home is not primary store --}}
@if (config('app.storeId') != SC_ID_ROOT && function_exists('sc_vendor_get_categories_front') &&  count(sc_vendor_get_categories_front(config('app.storeId'))))
<div class="aside-item col-sm-6 col-md-5 col-lg-12">
  <h6 class="aside-title">{{ sc_language_render('front.categories_store') }}</h6>
  <ul class="list-shop-filter">
    @foreach (sc_vendor_get_categories_front(config('app.storeId')) as $key => $category)
    <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->getTitle() }}</a></li>
    @endforeach
  </ul>
</div>
@endif
{{-- //Categories tore --}}


{{-- Render include view --}}
@if (!empty($layout_page && $includePathView = config('sc_include_view.'.$layout_page, [])))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render include view --}}

@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
@php
  $bannerStore = $modelBanner->start()->getBannerStore()->getData()->first();
  $bannerImage = $bannerStore['image'] ?? '';
@endphp
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{ sc_file($bannerImage) }}">
    <div class="material-parallax parallax"><img src="{{ sc_file($bannerImage) }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);"></div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{ sc_route('home') }}">{{ sc_language_render('front.home') }}</a></li>
        <li class="active">{{ $title ?? '' }}</li>
      </ul>
    </div>
  </div>
</section>
@endsection
{{-- //breadcrumb --}}

@push('styles')
@endpush

@push('scripts')
<script type="text/javascript">
  $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
  });
</script>

{{-- Render include script --}}
@if (!empty($layout_page) && $includePathScript = config('sc_include_script.'.$layout_page, []))
@foreach ($includePathScript as $script)
  @if (view()->exists($script))
    @include($script)
  @endif
@endforeach
@endif
{{--// Render include script --}}

@endpush