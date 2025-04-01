@php
/*
$layout_page = front_search
**Variables:**
- $itemsList: paginate
Use paginate: $itemsList->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($GP247TemplatePath.'.layout')

@section('block_main_content_center')
<div class="col-lg-9 col-xl-9">
<h6 class="aside-title">{{ $title }}</h6>
<section class="section section-xl bg-default">
    <div class="container">
      <div class="row row-30">
        @if ($itemsList->count())
            @foreach ($itemsList as $item)
            <div class="col-sm-6 col-lg-4 text-center">
                {{-- Render item single --}}
                @php
                    $item['thumb'] = $item->getThumb();
                    $item['url'] = $item->getUrl();
                    $item['title'] = $item->title;
                @endphp
                @include($GP247TemplatePath.'.common.item_single', ['item' => $item])               
                {{-- //Render item single --}}
            </div>
            @endforeach

        {{-- Render pagination --}}
        @include($GP247TemplatePath.'.common.pagination', ['items' => $itemsList])
        {{--// Render pagination --}}

        @else
            {!! gp247_language_render('front.no_item') !!}
        @endif
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
{{-- //script here --}}
@endpush

@push('styles')
{{-- Your css style --}}
@endpush