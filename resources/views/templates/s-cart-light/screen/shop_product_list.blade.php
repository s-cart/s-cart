@php
/*
$layout_page = shop_product_list
**Variables:**
- $subCategory: paginate
Use paginate: $subCategory->appends(request()->except(['page','_token']))->links()
- $products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/ 
@endphp

@extends($sc_templatePath.'.layout')

{{-- block_main_content_center --}}
@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">

  {{-- sub category --}}
  @isset ($subCategory)
  @if($subCategory->count())
  <h6 class="aside-title">{{ sc_language_render('front.sub_categories') }}</h6>
  <div class="row item-folder">
      @foreach ($subCategory as $key => $item)
      <div class="col-6 col-sm-6 col-md-3">
          <div class="item-folder-wrapper product-single">
              <div class="single-products">
                  <div class="productinfo text-center product-box-{{ $item->id }}">
                      <a href="{{ $item->getUrl() }}"><img src="{{ sc_file($item->getThumb()) }}"
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
              {{ $subCategory->appends(request()->except(['page','_token']))->links() }}
          </ul>
      </div>
  </div>
  @endif
  @endisset
  {{-- //sub category --}}

  {{-- Sort filter --}}
  <div class="product-top-panel group-md">
    <p class="product-top-panel-title">
      {!! sc_language_render('front.result_item', ['item_from' => $products->firstItem(), 'item_to'=> $products->lastItem(), 'total'=> $products->total()  ]) !!}
    </p>
        <form action="" method="GET" id="filter_sort">
          @php
          $queries = request()->except(['filter_sort','page']);
          @endphp
          @foreach ($queries as $key => $query)
          <input type="hidden" name="{{ $key }}" value="{{ $query }}">
          @endforeach
          
          <select class="form-control" name="filter_sort">
              <option value="">{{ sc_language_render('filter_sort.sort') }}</option>
              <option value="price_asc" {{ ($filter_sort =='price_asc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.price_asc') }}</option>
              <option value="price_desc" {{ ($filter_sort =='price_desc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.price_desc') }}</option>
              <option value="sort_asc" {{ ($filter_sort =='sort_asc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.sort_asc') }}</option>
              <option value="sort_desc" {{ ($filter_sort =='sort_desc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.sort_desc') }}</option>
              <option value="id_asc" {{ ($filter_sort =='id_asc')?'selected':'' }}>
                {{ sc_language_render('filter_sort.id_asc') }}
              </option>
              <option value="id_desc" {{ ($filter_sort =='id_desc')?'selected':'' }}>
                  {{ sc_language_render('filter_sort.id_desc') }}</option>
          </select>
        </form>
  </div>
  {{-- //Sort filter --}}

  {{-- Product list --}}
  <div class="row row-30 row-lg-50">
    @foreach ($products as $key => $product)
    <div class="col-sm-6 col-md-4 col-lg-6 col-xl-4">
        {{-- Render product single --}}
        @includeIf($sc_templatePath.'.common.product_single', ['product' => $product])
        {{-- //Render product single --}}
    </div>
    @endforeach
  </div>

  <div class="pagination-wrap">
    <!-- Bootstrap Pagination-->
    <nav aria-label="Page navigation">
      <ul class="pagination">
        {{ $products->appends(request()->except(['page','_token']))->links() }}
      </ul>
    </nav>
  </div>
  {{-- //Product list --}}

{{-- Render include view --}}
@if (!empty($layout_page && $includePathView = config('sc_include_view.'.$layout_page, [])))
@foreach ($includePathView as $view)
   @includeIf($view)
@endforeach
@endif
{{--// Render include view --}}

@endsection
{{-- //block_main_content_center --}}


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
<script type="text/javascript">
  $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
  });
</script>

{{-- Render include script --}}
@if (!empty($layout_page) && $includePathScript = config('sc_include_script.'.$layout_page, []))
@foreach ($includePathScript as $script)
   @includeIf($script)
@endforeach
@endif
{{--// Render include script --}}
@endpush