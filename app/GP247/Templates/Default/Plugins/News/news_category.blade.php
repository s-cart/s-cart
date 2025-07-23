@php
/*
$layout_page = news_category
**Variables:**
- $newsCategory
- $entries: paginate
Use paginate: $entries->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($GP247TemplatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default">
  <div class="container">
    <div class="row row-30">
      @if ($entries->count())
          @foreach ($entries as $entryDetail)
          <div class="col-sm-6 col-lg-4">
          {{-- Render entry single --}}
          @php
            $item['thumb'] = $entryDetail->getThumb();
            $item['url'] = $entryDetail->getUrl();
            $item['title'] = $entryDetail->title;
            $item['description'] = $entryDetail->description;
            $item['created_at'] = $entryDetail->created_at;
          @endphp
          @include($GP247TemplatePath.'.common.item_single_long', ['item' => $item])
          {{-- //Render entry single --}}
          </div>
          @endforeach

      {{-- Render pagination --}}
      @include($GP247TemplatePath.'.common.pagination', ['items' => $entries])
      {{--// Render pagination --}}

      @else
          {!! gp247_language_render('front.no_item') !!}
      @endif
    </div>

  </div>
</section>


@endsection


@push('scripts')
  {{-- Script here --}}
@endpush
