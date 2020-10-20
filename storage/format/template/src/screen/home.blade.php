@php
/*
$layout_page = home
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
@php
$productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->getData();
@endphp
          <div class="features_items"><!--features_items-->
            <h2 class="title text-center">{{ trans('front.products_new') }}</h2>
                @foreach ($productsNew as  $key => $productNew)
                  <div class="col-sm-4">
                    <div class="product-image-wrapper product-single">
                      <div class="single-products product-box-{{ $productNew->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $productNew->getUrl() }}"><img src="{{ asset($productNew->getThumb()) }}" alt="{{ $productNew->name }}" /></a>
                            {!! $productNew->showPrice() !!}
                            <a href="{{ $productNew->getUrl() }}"><p>{{ $productNew->name }}</p></a>

                            @if ($productNew->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $productNew->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
                            @endif

                          </div>
                      @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($productNew->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($productNew->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @endif
                      </div>
                      <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                          <li><a onClick="addToCartAjax('{{ $productNew->id }}','wishlist')"><i class="fa fa-plus-square"></i>{{trans('front.add_to_wishlist')}}</a></li>
                          <li><a onClick="addToCartAjax('{{ $productNew->id }}','compare')"><i class="fa fa-plus-square"></i>{{trans('front.add_to_compare')}}</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
               @endforeach
          </div><!--features_items-->
@endsection



@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
      {{-- script --}}
@endpush