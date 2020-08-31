@php
/*
$layout_page = item_list
$itemsList: paginate
Use paginate: $itemsList->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">
<h6 class="aside-title">{{ $title }}</h6>
<section class="section section-xl bg-default">
    <div class="container">
      <div class="row row-30">
        @if ($itemsList->count())
            @foreach ($itemsList as $item)
            <div class="col-sm-6 col-lg-4 text-center">
                <!-- Post Classic-->
                <article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $item->getUrl() }}">
                    <img src="{{ asset($item->getThumb()) }}" alt="" width="370" height="239"></a>
                    <h5 class="post-classic-title"><a href="{{ $item->getUrl() }}">{{ $item->name }}</a></h5>
                </article>
              </div>
            @endforeach

            <div class="pagination-wrap">
                <!-- Bootstrap Pagination-->
                <nav aria-label="Page navigation">
                    {{ $itemsList->links() }}
                </nav>
            </div>

        @else
            {!! trans('front.no_data') !!}
        @endif
      </div>
    </div>
  </section>
</div>
@endsection


{{-- breadcrumb --}}
@section('breadcrumb')
@php
$bannerBreadcrumb = $modelBanner->start()->getBannerBreadcrumb()->getData()->first();
@endphp
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{ asset($bannerBreadcrumb['image'] ?? '') }}">
    <div class="material-parallax parallax"><img src="{{ asset($bannerBreadcrumb['image'] ?? '') }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);"></div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title ?? '' }}</li>
      </ul>
    </div>
  </div>
</section>
@endsection
{{-- //breadcrumb --}}


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
                <option value="name_asc" {{ ($filter_sort =='name_asc')?'selected':'' }}>
                    {{ trans('front.filters.name_asc') }}</option>
                <option value="name_desc" {{ ($filter_sort =='name_desc')?'selected':'' }}>
                    {{ trans('front.filters.name_desc') }}</option>
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

@push('scripts')
<script type="text/javascript">
    $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
    });
</script>
@endpush
