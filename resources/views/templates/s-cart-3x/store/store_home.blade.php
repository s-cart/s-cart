@php
/*
$layout_page = store_home
*/ 
@endphp

@extends($sc_templatePath.'.layout')
@php
$productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->setStore($storeId)->getData();
@endphp

@section('block_main')
      <!-- New Products-->
      <section class="section section-xxl bg-default">
        <div class="container">
          <h2 class="wow fadeScale">{{ trans('front.features_items') }}</h2>
          <div class="row row-30 row-lg-50">
            @foreach ($productsNew as $key => $productNew)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <!-- Product-->
                <article class="product wow fadeInRight">
                  <div class="product-body">
                    <div class="product-figure">
                        <a href="{{ $productNew->getUrl() }}">
                        <img src="{{ asset($productNew->getThumb()) }}" alt="{{ $productNew->name }}"/>
                        </a>
                    </div>
                    <h5 class="product-title"><a href="{{ $productNew->getUrl() }}">{{ $productNew->name }}</a></h5>
                    @if ($productNew->allowSale())
                    <a onClick="addToCartAjax('{{ $productNew->id }}','default')" class="button button-lg button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{trans('front.add_to_cart')}}</a>
                    @endif

                    {!! $productNew->showPrice() !!}
                  </div>
                  
                  @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind != SC_PRODUCT_GROUP)
                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                  @elseif($productNew->kind == SC_PRODUCT_BUILD)
                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                  @elseif($productNew->kind == SC_PRODUCT_GROUP)
                  <span><img class="product-badge new" src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                  @endif
                  <div class="product-button-wrap">
                    <div class="product-button">
                        <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','wishlist')">
                            <i class="fas fa-heart"></i>
                        </a>
                    </div>
                    <div class="product-button">
                        <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','compare')">
                            <i class="fa fa-exchange"></i>
                        </a>
                    </div>
                  </div>
                </article>
              </div>
            @endforeach
          </div>
        </div>
      </section>      
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
  <h1>{{ sc_store('title', $storeId) }}</h1>
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
@endpush

@push('scripts')

@endpush
