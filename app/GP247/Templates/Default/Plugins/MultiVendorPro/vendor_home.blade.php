@php
/*
* This template only use for MultiVendorPro
$layout_page = vendor_home
*/ 
@endphp

@extends($GP247TemplatePath.'.layout')

@section('block_main_content_center')

@php
  $subPath = 'vendor_info';
  $view = gp247_plugin_process_view($appPath, $GP247TemplatePath, $subPath);
@endphp
@includeIf($view, ['storeId' => $storeId])

@if ($products->count())

  {{-- Sort filter --}}
  <div class="product-top-panel group-md">

    {{-- Render pagination result --}}
    @include($GP247TemplatePath.'.common.pagination_result', ['items' => $products])
    {{--// Render pagination result --}}

      <!-- Render include filter sort -->
      @php
        $subPath = 'common.shop_product_filter_sort';
        $view = gp247_shop_process_view($GP247TemplatePath, $subPath);
      @endphp
      @include($view, ['filterSort' => $filter_sort])
      <!--// Render include filter sort -->

  </div>
  {{-- //Sort filter --}}


  <div class="container">
    <h4 class="wow fadeScale">{{ gp247_language_render('front.products_new') }}</h4>
    <div class="row row-30 row-lg-50">
      @foreach ($products as $key => $product)
      <div class="col-sm-6 col-md-4">
        {{-- Render product single --}}
        @php
        $view = gp247_shop_process_view($GP247TemplatePath, 'common.shop_product_single');
        @endphp
        @include($view, ['product' => $product])
        {{-- //Render product single --}}
      </div>
      @endforeach
    </div>
  </div>

{{-- Render pagination --}}
@includeIf($GP247TemplatePath.'.common.pagination', ['items' => $products])
{{--// Render pagination --}}


  @else
    <div class="product-top-panel group-md">
      <p style="text-align:center">{!! gp247_language_render('front.no_item') !!}</p>
    </div>
  @endif

@endsection

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


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
@endpush
