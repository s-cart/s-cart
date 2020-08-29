@php
/*
$layout_page = shop_home
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
  @php
      $productsNew = $modelProduct->start()->getProductLatest()->setlimit(8)->getData();
      $productsHot = $modelProduct->start()->getProductHot()->getData();
      $productsBuild = $modelProduct->start()->getProductBuild()->getData();
      $productsGroup = $modelProduct->start()->getProductGroup()->getData();
  @endphp
          <div class="features_items"><!--features_items-->
            <h2 class="title text-center">{{ trans('front.features_items') }}</h2>
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

          <div class="recommended_items"><!--recommended_items-->
            <h2 class="title text-center">{{ trans('front.products_hot') }}</h2>

            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                @foreach ($productsHot as  $key => $productHot)
                @if ($key % 3 == 0)
                  <div class="item {{  ($key ==0)?'active':'' }}">
                @endif
                  <div class="col-sm-4">
                    <div class="product-image-wrapper product-single">
                      <div class="single-products   product-box-{{ $productHot->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $productHot->getUrl() }}"><img src="{{ asset($productHot->getThumb()) }}" alt="{{ $productHot->name }}" /></a>
                            {!! $productHot->showPrice() !!}
                            <a href="{{ $productHot->getUrl() }}"><p>{{ $productHot->name }}</p></a>
                            @if ($productHot->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $productHot->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
                            @endif
                          </div>

                      @if ($productHot->price != $productHot->getFinalPrice() && $productHot->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($productHot->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($productHot->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @endif

                      </div>
                      <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                          <li><a onClick="addToCartAjax('{{ $productHot->id }}','wishlist')"><i class="fa fa-plus-square"></i>{{trans('front.add_to_wishlist')}}</a></li>
                          <li><a onClick="addToCartAjax('{{ $productHot->id }}','compare')"><i class="fa fa-plus-square"></i>{{trans('front.add_to_compare')}}</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                @if ($key % 3 == 2 || $key+1 == $productsHot->count())
                  </div>
                @endif
               @endforeach

              </div>
               <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
                </a>
            </div>
          </div><!--/recommended_items-->

          <div class="category-tab"><!--category-tab-->
            <div class="col-sm-12">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#cate1" data-toggle="tab">{{ trans('front.products_build') }}</a></li>
                  <li><a href="#cate2" data-toggle="tab">{{ trans('front.products_group') }}</a></li>
              </ul>
            </div>
            <div class="tab-content">

                <div class="tab-pane fade active in" id="cate1" >
                  @foreach ($productsBuild as $product)
                    <div class="col-sm-3">
                      <div class="product-image-wrapper product-single">
                        <div class="single-products  product-box-{{ $product->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product->getUrl() }}"><img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" /></a>
                            {!! $product->showPrice() !!}
                            <a href="{{ $product->getUrl() }}"><p>{{ $product->name }}</p></a>
                            @if ($product->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
                            @endif
                          </div>

                      @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($product->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($product->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @endif
                        </div>
                      </div>
                    </div>
                @endforeach
              </div>
                <div class="tab-pane fade" id="cate2" >
                  @foreach ($productsGroup as $product)
                    <div class="col-sm-3">
                      <div class="product-image-wrapper product-single">
                        <div class="single-products  product-box-{{ $product->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product->getUrl() }}"><img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" /></a>
                            {!! $product->showPrice() !!}
                            <a href="{{ $product->getUrl() }}"><p>{{ $product->name }}</p></a>
                            @if ($product->allowSale())
                             <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product->id }}','default')"><i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                            @else
                              &nbsp;
                            @endif
                          </div>

                      @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                      @elseif($product->kind == SC_PRODUCT_BUILD)
                      <img src="{{ asset($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                      @elseif($product->kind == SC_PRODUCT_GROUP)
                      <img src="{{ asset($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" />
                      @endif
                        </div>
                      </div>
                    </div>
                @endforeach
                </div>
          </div><!--/category-tab-->


@endsection



@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
      {{-- script --}}
@endpush