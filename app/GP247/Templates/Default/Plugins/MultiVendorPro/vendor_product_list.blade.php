@php
/*
* This template only use for MultiVendorPro
$layout_page = vendor_product_list
**Variables:**
- $products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/ 
@endphp

@extends($GP247TemplatePath.'.layout')

{{-- block_main_content_center --}}
@section('block_main_content_center')

@php
  $subPath = 'vendor_info';
  $view = gp247_plugin_process_view($appPath, $GP247TemplatePath, $subPath);
@endphp
@includeIf($view, ['storeId' => $storeId])

@if ($products->count())

  <div class="box-filters mt-0 pb-5 border-bottom">
    <div class="row">
      <div class="col-xl-12 col-lg-12 mb-10 text-lg-end text-center">
      <!-- Render pagination result -->
      @include($GP247TemplatePath.'.common.pagination_result', ['items' => $products])
      <!--// Render pagination result -->
        <div class="d-inline-block">
        <!-- Render include filter sort -->
        @include($GP247TemplatePath.'.common.product_filter_sort', ['filterSort' => $filter_sort])
        <!--// Render include filter sort -->
        </div>
      </div>
    </div>
  </div>

    <!-- Product list -->
    <div class="row mt-20">
      @foreach ($products as $key => $product)
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
        {{-- Render product single --}}
        @php
        $view = gp247_shop_process_view($GP247TemplatePath, 'common.shop_product_single');
        @endphp
        @include($view, ['product' => $product])
        {{-- //Render product single --}}
        </div>
      @endforeach
    </div>
    <!-- //Product list -->

    <!-- Render pagination -->
    @include($GP247TemplatePath.'.common.pagination', ['items' => $products])
    <!--// Render pagination -->


   @else
   <div class="product-top-panel group-md">
     <p style="text-align:center">{!! gp247_language_render('front.no_item') !!}</p>
   </div>
 @endif

@endsection
{{-- //block_main_content_center --}}


@section('blockStoreLeft')
{{-- Categories tore --}}

@if (function_exists('gp247_vendor_get_categories_front') &&  count(gp247_vendor_get_categories_front($storeId)))
<div class="aside-item col-sm-6 col-md-5 col-lg-12">
  <h6 class="aside-title">{{ gp247_language_render('front.categories_store') }}</h6>
  <ul class="list-shop-filter">
    @foreach (gp247_vendor_get_categories_front($storeId) as $category)
    <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->title }}</a></li>
    @endforeach
  </ul>
</div>
@endif
{{-- //Categories tore --}}
@endsection


@push('scripts')

@endpush

@push('styles')
{{-- Your css style --}}
@endpush