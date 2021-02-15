@php
/*
* This template only use for MultiVendorPro
$layout_page = store_home
*/ 
@endphp

@extends($sc_templatePath.'.layout')
@php
$productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top', $storeId))->setStore($storeId)->getData();
@endphp

@section('block_main_content_center')
      <!-- New Products-->
      <div class="col-lg-8 col-xl-9">
        <div class="container">
          <h2 class="wow fadeScale">{{ trans('front.products_new') }}</h2>
          <div class="row row-30 row-lg-50">
            @foreach ($productsNew as $key => $productNew)
            <div class="col-sm-6 col-md-4">
                <!-- Product-->
                <article class="product wow fadeInRight">
                  <div class="product-body">
                    <div class="product-figure">
                        <a href="{{ $productNew->getUrl() }}">
                        <img src="{{ asset($productNew->getThumb()) }}" alt="{{ $productNew->name }}"/>
                        </a>
                    </div>
                    <h5 class="product-title"><a href="{{ $productNew->getUrl() }}">{{ $productNew->name }}</a></h5>
                    {{-- Button add to cart --}}
                    @if ($productNew->allowSale())
                    <a onClick="addToCartAjax('{{ $productNew->id }}','default','{{ $productNew->store_id }}')" class="button button-lg button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
                    @endif
                    {{--// Button add to cart --}}

                    {!! $productNew->showPrice() !!}
                  </div>
                  
                  {{-- Product type --}}
                  @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind != SC_PRODUCT_GROUP)
                    <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                  @elseif($productNew->kind == SC_PRODUCT_BUILD)
                    <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                  @elseif($productNew->kind == SC_PRODUCT_GROUP)
                    <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                  @endif
                  {{--// Product type --}}

                  {{-- Wishlist, compare --}}
                  <div class="product-button-wrap">
                    <div class="product-button">
                        <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','wishlist','{{ $productNew->store_id }}')">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                    <div class="product-button">
                        <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','compare','{{ $productNew->store_id }}')">
                            <i class="fa fa-exchange"></i>
                        </a>
                    </div>
                  </div>
                  {{--// Wishlist, compare --}}

                </article>
              </div>
            @endforeach
          </div>
        </div>

        @if (function_exists('sc_vendor_get_categories_front') &&  count(sc_vendor_get_categories_front($storeId)))
        @foreach (sc_vendor_get_categories_front($storeId) as $category)
        <section class="section section-xxl bg-default">
          <div class="container">
                <h2 class="wow fadeScale">{{ $category->getTitle() }}</h2>
                <div class="row row-30 row-lg-50">
                  @php
                      $products = $modelProduct->start()->setStore($storeId)->getProductToCategoryStore($category->id)
                      ->setLimit(sc_config('product_top', $storeId))->getData()
                  @endphp
                  @foreach ($products as $key => $product)
                  <div class="col-sm-6 col-md-4">
                      <!-- Product-->
                      <article class="product wow fadeInRight">
                        <div class="product-body">
                          <div class="product-figure">
                              <a href="{{ $product->getUrl() }}">
                              <img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}"/>
                              </a>
                          </div>
                          <h5 class="product-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></h5>

                          {{-- Button add to cart --}}
                          @if ($product->allowSale())
                          <a onClick="addToCartAjax('{{ $product->id }}','default', '{{ $product->store_id }}')" class="button button-lg button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
                          @endif
                          {{--// Button add to cart --}}

                          {!! $product->showPrice() !!}
                        </div>
                        
                        {{-- Product type --}}
                        @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                          <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                        @elseif($product->kind == SC_PRODUCT_BUILD)
                          <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                        @elseif($product->kind == SC_PRODUCT_GROUP)
                          <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                        @endif
                        {{--// Product type --}}

                        {{-- Wishlist, compare --}}
                        <div class="product-button-wrap">
                          <div class="product-button">
                              <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','wishlist', '{{ $product->store_id }}')">
                                  <i class="fas fa-heart"></i>
                              </a>
                          </div>
                          <div class="product-button">
                              <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','compare', '{{ $product->store_id }}')">
                                  <i class="fa fa-exchange"></i>
                              </a>
                          </div>
                        </div>
                        {{--// Wishlist, compare --}}

                      </article>
                    </div>
                  @endforeach
                </div>
          </div>
        </section>
        @endforeach
        @endif
  
      </div>

{{-- Render block include view --}}
@if ($includePathView = config('sc_include_view.store_home', []))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render block include view --}}

@endsection

@section('blockStoreLeft')
  {{-- Categories tore --}}
  @if (function_exists('sc_vendor_get_categories_front') &&  count(sc_vendor_get_categories_front($storeId)))
  <div class="aside-item col-sm-6 col-md-5 col-lg-12">
    <h6 class="aside-title">{{ trans('front.categories_store') }}</h6>
    <ul class="list-shop-filter">
      @foreach (sc_vendor_get_categories_front($storeId) as $category)
      <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->getTitle() }}</a></li>
      @endforeach
    </ul>
  </div>
  @endif
  {{-- //Categories tore --}}
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
@php
$bannerStore = $modelBanner->start()->getBannerStore()->setStore($storeId)->getData()->first();
@endphp
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{ asset($bannerStore['image'] ?? '') }}">
    <div class="material-parallax parallax">
      <img src="{{ asset($bannerStore['image'] ?? '') }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);">
    </div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ sc_store('title', $storeId) }}</li>
      </ul>
    </div>
  </div>
</section>
@endsection
{{-- //breadcrumb --}}


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
  {{-- Render block include script --}}
  @if ($includePathScript = config('sc_include_script.store_home', []))
  @foreach ($includePathScript as $script)
    @if (view()->exists($script))
      @include($script)
    @endif
  @endforeach
  @endif
  {{--// Render block include script --}}
@endpush
