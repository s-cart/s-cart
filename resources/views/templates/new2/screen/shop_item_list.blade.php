@php
/*
$layout_page = item_list
$itemsList: paginate
Use paginate: $itemsList->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($templatePath.'.layout')

@section('main')

<div class="col-12">
    <h2 class="title-page">{{ $title }}</h2>
</div>
@if (!empty($itemsList))
<div class="col-12">
    <div class="row min-height-37vh ">
        @foreach ($itemsList as $item)
        <div class="col-sm-6 col-6 col-md-3">
            <div class="product-image-wrapper product-single">
                <div class="single-products">
                    <div class="productinfo text-center product-box-{{ $item->id }}">
                        <a href="{{ $item->getUrl() }}"><img src="{{ asset($item->getImage()) }}"
                                alt="{{ $item->name }}" /></a>
                        <a href="{{ $item->getUrl() }}">
                            <p>{{ $item->name }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
<div style="clear: both; ">
    <ul class="pagination">
        {{ $itemsList->appends(request()->except(['page','_token']))->links() }}
    </ul>
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
