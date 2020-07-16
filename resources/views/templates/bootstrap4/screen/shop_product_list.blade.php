@php
/*
$layout_page = product_list
$itemsList: paginate
Use paginate: $itemsList->appends(request()->except(['page','_token']))->links()
$products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/ 
@endphp

@extends($templatePath.'.layout')

@section('center')
  <div class="row">
    @isset ($itemsList)
      @if($itemsList->count())
      <!--product add start-->
        @foreach ($itemsList as  $key => $item)
        <div class="col-12 col-lg-6 mt-5 mb-5 mt-lg-0">
          <div class="position-relative rounded overflow-hidden text-right shadow-sm">
            <!-- Background -->
            <a href="{{ $item->getUrl() }}" >
              <img class="img-fluid hover-zoom" src="{{ asset($item->getThumb()) }}" alt="{{ $item->title }}">
            </a>
            <!-- Body -->
            <div class="position-absolute top-50 pl-5 text-left">
              <h6 class="text-dark">Summer Collection</h6>
                <!-- Heading -->
                <h3 class="font-w-7">{{ $item->title }}</h3>
                <!-- Link --> 
                <a class="btn btn-sm btn-primary btn-animated" href="{{ $item->getUrl() }}">
                  Shop Now
                </a>
                </div>
              </div>
            </div>
          @endforeach
        <div style="clear: both; ">
          <ul class="pagination">
            {{ $itemsList->appends(request()->except(['page','_token']))->links() }}
          </ul>
        </div>
      @endif
    @endisset
</div>
<!--product add end-->

  @if (count($products) ==0)
  <div class="row">
    <div class="col-12 col-lg-6 mt-5 mb-5 mt-lg-0">

    {{ trans('front.empty_product') }}
    </div>
  @else
    @foreach ($products as  $key => $product)
    <div class="col-12 col-lg-6 mt-5 mb-5 mt-lg-0">
        <div class="product-image-wrapper product-single">
          <div class="single-products">
            <div class="productinfo text-center product-box-{{ $product->id }}">
              <a href="{{ $product->getUrl() }}"><img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}" /></a>

              {!! $product->showPrice() !!}

              <a href="{{ $product->getUrl() }}"><p>{{ $product->name }}</p></a>

                @if ($product->allowSale())
                  <a class="btn btn-default add-to-cart" onClick="addToCartAjax('{{ $product->id }}','default')">
                    <i class="fa fa-shopping-cart"></i>{{trans('front.add_to_cart')}}
                </a>
                @else
                  &nbsp;
                @endif
            </div>
                @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                @elseif($product->kind == SC_PRODUCT_BUILD)
                <img src="{{ asset($templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                @elseif($product->kind == SC_PRODUCT_GROUP)
                <img src="{{ asset($templateFile.'/images/home/group.png') }}" class="new" alt="" />
                @endif
          </div>
          <div class="choose">
            <ul class="nav nav-pills nav-justified">
              <li><a  onClick="addToCartAjax({{ $product->id }},'wishlist')"><i class="fa fa-plus-square"></i>{{trans('front.add_to_wishlist')}}</a></li>
              <li><a  onClick="addToCartAjax({{ $product->id }},'compare')"><i class="fa fa-plus-square"></i>{{trans('front.add_to_compare')}}</a></li>
            </ul>
          </div>
        </div>
    </div>
    @endforeach
  @endif

  <div style="clear: both; ">
      <ul class="pagination">
        {{ $products->appends(request()->except(['page','_token']))->links() }}
    </ul>
  </div>
@endsection

@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-1 m-0">
      <li class="breadcrumb-item">
        <a class="text-dark" href="{{ route('home') }}"><i class="las la-home mr-1"></i>{{ trans('front.home') }}</a>
      </li>
      <li class="breadcrumb-item active text-primary" aria-current="page">{{ $title }}</li>
    </ol>
  </nav>
@endsection

@section('filter')
  <form action="" method="GET" id="filter_sort">
    <div class="row mb-4 align-items-center">
      <div class="col-md-5 mb-3 mb-md-0"> 
        <span class="text-muted">
          <h3 class="text-primary mb-1">— {{ $title }}</h3>
        </span>
      </div>
      <div class="col-md-7 d-flex align-items-center justify-content-md-end">
        <div class="view-filter"> 
          <a class="active" href="#"><i class="lab la-buromobelexperte"></i></a>
          <a href="#"><i class="las la-list"></i></a>
        </div>
        <div class="sort-filter ml-2 d-flex align-items-center">
          @php
            $queries = request()->except(['filter_sort','page']);
          @endphp
          @foreach ($queries as $key => $query)
            <input type="hidden" name="{{ $key }}" value="{{ $query }}">
          @endforeach

          <select class="custom-select" name="filter_sort" id="inputGroupSelect02">
            <option value="">{{ trans('front.filters.sort') }}</option>
            <option value="price_asc" {{ ($filter_sort =='price_asc')?'selected':'' }}>{{ trans('front.filters.price_asc') }}</option>
            <option value="price_desc" {{ ($filter_sort =='price_desc')?'selected':'' }}>{{ trans('front.filters.price_desc') }}</option>
            <option value="sort_asc" {{ ($filter_sort =='sort_asc')?'selected':'' }}>{{ trans('front.filters.sort_asc') }}</option>
            <option value="sort_desc" {{ ($filter_sort =='sort_desc')?'selected':'' }}>{{ trans('front.filters.sort_desc') }}</option>
            <option value="id_asc" {{ ($filter_sort =='id_asc')?'selected':'' }}>{{ trans('front.filters.id_asc') }}</option>
            <option value="id_desc" {{ ($filter_sort =='id_desc')?'selected':'' }}>{{ trans('front.filters.id_desc') }}</option>
          </select>
        </div>
      </div>
    </div>
  </form>

@endsection

@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
  <script type="text/javascript">
    $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
    });
  </script>
@endpush
