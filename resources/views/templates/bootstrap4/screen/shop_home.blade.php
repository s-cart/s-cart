@php
/*
$layout_page = shop_home
*/ 
@endphp

@extends($templatePath.'.layout')

@section('center')
  @php
      $productsNew = $modelProduct->start()->getProductLatest()->setlimit(9)->getData();
      $productsHot = $modelProduct->start()->getProductHot()->getData();
      $productsBuild = $modelProduct->start()->getProductBuild()->getData();
      $productsGroup = $modelProduct->start()->getProductGroup()->getData();
  @endphp
      <div class="row mb-4 align-items-center">
      <div class="col-md-5 mb-3 mb-md-0"> <span class="text-muted"></span>
      </div>
      <div class="col-md-7 d-flex align-items-center justify-content-md-end">
        <div class="view-filter"> <a class="active" href="shop-grid-left-sidebar.html"><i class="lab la-buromobelexperte"></i></a>
          <a href="shop-list-left-sidebar.html"><i class="las la-list"></i></a>
        </div>
        <div class="sort-filter ml-2 d-flex align-items-center">
          <select class="custom-select" id="inputGroupSelect02">
            <option selected>Sort By</option>
            <option value="1">Newest Item</option>
            <option value="2">Populer</option>
            <option value="3">Best Match</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      @foreach($productsNew as  $key => $productNew)
        <div class="col-lg-4 col-md-6">
          <div class="card product-card">
            <button class="btn-wishlist btn-sm" type="button" data-toggle="tooltip" data-placement="left" title="Add to wishlist">
              <i class="lar la-heart"></i>
            </button>
            <a class="card-img-hover d-block" href="{{$productNew->getUrl()}}">
              <img class="card-img-top card-img-back" src="{{asset($productNew->getThumb())}}" alt="...">
              <img class="card-img-top card-img-front" src="{{asset($productNew->getThumb())}}" alt="...">
            </a>
            <div class="card-info">
              <div class="card-body">
                <div class="product-title">
                  <a class="link-title" href="{{$productNew->getUrl()}}">{{$productNew->name}}</a>
                </div>
                @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind != SC_PRODUCT_GROUP)
                  <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                @elseif($productNew->kind == SC_PRODUCT_BUILD)
                  <img src="{{ asset($templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                @elseif($productNew->kind == SC_PRODUCT_GROUP)
                  <img src="{{ asset($templateFile.'/images/home/group.png') }}" class="new" alt="" />
                @endif
                <div class="mt-1"> <span class="product-price">{!! $productNew->showPrice() !!}</span>
                  <div class="star-rating"><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i>
                  </div>
                </div>
              </div>
              <div class="card-footer bg-transparent border-0">
                <div class="product-link d-flex align-items-center justify-content-center">
                  <button class="btn btn-compare" data-toggle="tooltip" data-placement="top" title="Compare" type="button">
                    <i class="las la-random"></i>
                  </button>
                  <button onClick="addToCartAjax('{{ $productNew->id }}','wishlist')" class="btn-cart btn btn-primary btn-animated mx-2" type="button">
                    <i class="las la-shopping-basket mr-1"></i>
                  </button>
                  @if ($productNew->allowSale())
                    <button onClick="addToCartAjax('{{ $productNew->id }}','default')" class="btn-cart btn btn-primary btn-animated mx-2" type="button">
                      <i class="las la-shopping-cart mr-1"></i>
                    </button>
                  @else
                    &nbsp;
                  @endif
                  <button class="btn btn-view" data-toggle="tooltip" data-placement="top" title="Quick View">
                    <span data-target="#quick-view" data-toggle="modal">
                      <i class="las la-eye"></i>
                    </span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <nav aria-label="Page navigation" class="mt-8">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">2</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>


    <!--Hot product start-->

<section class="pb-0 pt-0 mt-8">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8 col-md-10">
        <div class="mb-8">
          <h6 class="text-primary mb-1">
                  — New Collection
              </h6>
          <h2 class="mb-0">{{ trans('front.products_hot') }}</h2>
        </div>
      </div>
    </div>
    <div class="row">
      @foreach ($productsHot as  $key => $productHot)
      <div class="col-xl-3 col-lg-4 col-md-6">
        <div class="card product-card">
          <button class="btn-wishlist btn-sm" type="button" data-toggle="tooltip" data-placement="left" title="Add to wishlist">
            <i class="lar la-heart"></i>
          </button>
          <a class="card-img-hover d-block" href="{{ $productHot->getUrl() }}">
            <img class="card-img-top card-img-back" src="{{ asset($productHot->getThumb()) }}" alt="{{ $productHot->name }}">
            <img class="card-img-top card-img-front" src="{{ asset($productHot->getThumb()) }}" alt="{{ $productHot->name }}">
          </a>
          <div class="card-info">
            <div class="card-body">
              <div class="product-title"><a class="link-title" href="{{ $productHot->getUrl() }}">{{ $productHot->name }}</a>
              </div>
              <div class="mt-1"> 
                <span class="product-price">{!! $productHot->showPrice() !!}</span>
                <div class="star-rating"><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i>
                </div>
              </div>
            </div>
            <div class="card-footer bg-transparent border-0">
              <div class="product-link d-flex align-items-center justify-content-center">
                <button class="btn btn-compare p-1" data-toggle="tooltip" data-placement="top" title="Compare" type="button">
                  <i class="las la-random"></i> 
                </button>
                @if ($productHot->allowSale())
                  <button onClick="addToCartAjax('{{ $productNew->id }}','default')" class="btn-cart btn btn-primary p-1 btn-animated mx-1" type="button">
                    <i class="las la-shopping-cart mr-1"></i>
                  </button>
                @else
                  &nbsp;
                @endif
                <button onClick="addToCartAjax('{{ $productHot->id }}','compare')" class="btn-cart btn btn-primary p-1 btn-animated mx-1" type="button">
                  <i class="las la-shopping-basket mr-1"></i>
                </button>
                <button class="btn btn-view p-1" data-toggle="tooltip" data-placement="top" title="Quick View"><span data-target="#quick-view" data-toggle="modal"><i class="las la-eye"></i></span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!--Hot product end-->



  {{--<div   class = "category-tab">
    <div   class = "col-sm-12">
    <ul    class = "nav nav-tabs">
    <li    class = "active"><a href     = "#cate1" data-toggle = "tab">{{ trans('front.products_build') }}</a></li>
    <li><a href  = "#cate2" data-toggle = "tab">{{ trans('front.products_group') }}</a></li>
        </ul>
      </div>
      <div class = "tab-content">

          <div class = "tab-pane fade active in" id = "cate1" >
            @foreach ($productsBuild as $product)
              <div class = "col-sm-3">
              <div class = "product-image-wrapper product-single">
              <div class = "single-products  product-box-{{ $product->id }}">
              <div class = "productinfo text-center">
              <a   href  = "{{ $product->getUrl() }}"><img src = "{{ asset($product->getThumb()) }}" alt = "{{ $product->name }}" /></a>
                      {!! $product->showPrice() !!}
                      <a href = "{{ $product->getUrl() }}"><p>{{ $product->name }}</p></a>
                      @if ($product->allowSale())
                        <a class = "btn btn-default add-to-cart" onClick = "addToCartAjax('{{ $product->id }}','default')"><i class = "fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                      @else
                        &nbsp;
                      @endif
                    </div>

                @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                <img src = "{{ asset($templateFile.'/images/home/sale.png') }}" class = "new" alt = "" />
                @elseif($product->kind == SC_PRODUCT_BUILD)
                <img src = "{{ asset($templateFile.'/images/home/bundle.png') }}" class = "new" alt = "" />
                @elseif($product->kind == SC_PRODUCT_GROUP)
                <img src = "{{ asset($templateFile.'/images/home/group.png') }}" class = "new" alt = "" />
                @endif
                  </div>
                </div>
              </div>
          @endforeach
        </div>
        <div class = "tab-pane fade" id = "cate2" >
          @foreach ($productsGroup as $product)
            <div class = "col-sm-3">
            <div class = "product-image-wrapper product-single">
            <div class = "single-products  product-box-{{ $product->id }}">
            <div class = "productinfo text-center">
            <a   href  = "{{ $product->getUrl() }}"><img src = "{{ asset($product->getThumb()) }}" alt = "{{ $product->name }}" /></a>
                    {!! $product->showPrice() !!}
                    <a href = "{{ $product->getUrl() }}"><p>{{ $product->name }}</p></a>
                    @if ($product->allowSale())
                      <a class = "btn btn-default add-to-cart" onClick = "addToCartAjax('{{ $product->id }}','default')"><i class = "fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}</a>
                    @else
                      &nbsp;
                    @endif
                  </div>

              @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
              <img src = "{{ asset($templateFile.'/images/home/sale.png') }}" class = "new" alt = "" />
              @elseif($product->kind == SC_PRODUCT_BUILD)
              <img src = "{{ asset($templateFile.'/images/home/bundle.png') }}" class = "new" alt = "" />
              @elseif($product->kind == SC_PRODUCT_GROUP)
              <img src = "{{ asset($templateFile.'/images/home/group.png') }}" class = "new" alt = "" />
              @endif
                </div>
              </div>
            </div>
        @endforeach
        </div>
    </div>--}}


@endsection



@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
      {{-- script --}}
@endpush