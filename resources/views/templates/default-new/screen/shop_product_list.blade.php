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
<div class="features_items">
    <h2 class="title-page">{{ $title }}</h2>

    @isset ($itemsList)
    @if($itemsList->count())
    <div class="row item-folder">
        @foreach ($itemsList as $key => $item)
        <div class="col-6 col-sm-6 col-md-3">
            <div class="item-folder-wrapper product-single">
                <div class="single-products">
                    <div class="productinfo text-center product-box-{{ $item->id }}">
                        <a href="{{ $item->getUrl() }}"><img src="{{ asset($item->getThumb()) }}"
                                alt="{{ $item->title }}" /></a>
                        <a href="{{ $item->getUrl() }}">
                            <p>{{ $item->title }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div style="clear: both; ">
            <ul class="pagination">
              {{ $itemsList->appends(request()->except(['page','_token']))->links() }}
            </ul>
        </div>
    </div>
    @endif
    @endisset

    @if (count($products) ==0)
    {{ trans('front.empty_product') }}
    @else
    <div class="row">
        @foreach ($products as $key => $product)
        <div class="col-sm-4 col-6 col-md-3">
            <div class="product-item">
                <div class="product-main">
                    <div class="product-group">
                        @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                        <img src="{{ asset($templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                        @elseif($product->kind == SC_PRODUCT_BUILD)
                        <img src="{{ asset($templateFile.'/images/home/bundle.png') }}" class="new" alt="" />
                        @elseif($product->kind == SC_PRODUCT_GROUP)
                        <img src="{{ asset($templateFile.'/images/home/group.png') }}" class="new" alt="" />
                        @endif
                    </div>
                    <div class="product-photo">
                        <a href="{{ $product->getUrl() }}">
                            <img src="{{ asset($product->getThumb()) }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="product-name">
                        <a href="{{ $product->getUrl() }}">
                            <h4>{{ $product->name }}</h4>
                        </a>
                    </div>
                    <div class="product-price">
                        {!! $product->showPrice() !!}
                    </div>
                    <div class="product-add-cart">
                        @if ($product->allowSale())
                        <a href="" class="btn btn-default" onClick="addToCartAjax('{{ $product->id }}','default')">
                            <i class="fa fa-shopping-cart"></i> <span>{{trans('front.add_to_cart')}}</span>
                        </a>
                        @else
                        &nbsp;
                        @endif
                    </div>

                </div>
                <div class="product-choose">
                    <ul class="nav nav-pills nav-justified">
                        <li>
                            <a onClick="addToCartAjax('{{ $product->id }}','wishlist')">
                                <i class="fas fa-heart"></i> {{trans('front.add_to_wishlist')}}
                            </a>
                        </li>
                        <li>
                            <a onClick="addToCartAjax('{{ $product->id }}','compare')">
                                <i class="fas fa-exchange-alt"></i> {{trans('front.add_to_compare')}}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div style="clear: both; ">
        <ul class="pagination">
            {{ $products->appends(request()->except(['page','_token']))->links() }}
        </ul>
    </div>
</div>
@endsection


@section('breadcrumb')
<div class="breadcrumbs pull-left">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
    </ol>
</div>
@endsection

@section('filter')
<form action="" method="GET" id="filter_sort">
    <div class="pull-right">
        <div>
            @php
            $queries = request()->except(['filter_sort','page']);
            @endphp
            @foreach ($queries as $key => $query)
            <input type="hidden" name="{{ $key }}" value="{{ $query }}">
            @endforeach
            <select class="custom-select" name="filter_sort">
                <option value="">{{ trans('front.filters.sort') }}</option>
                <option value="price_asc" {{ ($filter_sort =='price_asc')?'selected':'' }}>
                    {{ trans('front.filters.price_asc') }}</option>
                <option value="price_desc" {{ ($filter_sort =='price_desc')?'selected':'' }}>
                    {{ trans('front.filters.price_desc') }}</option>
                <option value="sort_asc" {{ ($filter_sort =='sort_asc')?'selected':'' }}>
                    {{ trans('front.filters.sort_asc') }}</option>
                <option value="sort_desc" {{ ($filter_sort =='sort_desc')?'selected':'' }}>
                    {{ trans('front.filters.sort_desc') }}</option>
                <option value="id_asc" {{ ($filter_sort =='id_asc')?'selected':'' }}>{{ trans('front.filters.id_asc') }}
                </option>
                <option value="id_desc" {{ ($filter_sort =='id_desc')?'selected':'' }}>
                    {{ trans('front.filters.id_desc') }}</option>
            </select>
        </div>
    </div>
</form>

@endsection

@push('styles')
@endpush
@push('scripts')
<script type="text/javascript">
    $('[name="filter_sort"]').change(function(event) {
        $('#filter_sort').submit();
    });
</script>
@endpush