@php
/*
$layout_page = news_index
**Variables:**
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
            @foreach ($entries as $newsDetail)
            <div class="col-sm-6 col-lg-4">
              {{-- Render product single --}}
              @php
                $item['thumb'] = $newsDetail->getThumb();
                $item['url'] = $newsDetail->getUrl();
                $item['title'] = $newsDetail->title;
                $item['description'] = $newsDetail->description;
                $item['created_at'] = $newsDetail->created_at;
              @endphp
              @include($GP247TemplatePath.'.common.item_single_long', ['item' => $newsDetail])
              {{-- //Render product single --}}
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


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush