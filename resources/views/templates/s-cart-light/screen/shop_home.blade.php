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
  
  <div class="product-top-panel group-md">
    {{-- Render pagination result --}}
    @include($sc_templatePath.'.common.pagination_result', ['items' => $products])
    {{--// Render pagination result --}}
    
    {{-- Render include filter sort --}}
    @include($sc_templatePath.'.common.product_filter_sort', ['filterSort' => $filter_sort])
    {{--// Render include filter sort --}}
  </div>


  {{-- Product list --}}
  <div class="row row-30 row-lg-50">
    @foreach ($products as $key => $product)
    <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
        {{-- Render product single --}}
        @include($sc_templatePath.'.common.product_single', ['product' => $product])
        {{-- //Render product single --}}
      </div>
    @endforeach
  </div>
  {{-- //Product list --}}

   {{-- Render pagination --}}
   @include($sc_templatePath.'.common.pagination', ['items' => $products])
   {{--// Render pagination --}}

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
   @include($sc_templatePath.'.common.include_view')
   {{--// Render include view --}}

@endsection


@push('styles')
@endpush

@push('scripts')
{{-- //script here --}}
@endpush