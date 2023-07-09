@php
/*
$layout_page = content_list
**Variables:**
- $cmsCategory
- $entries: paginate
Use paginate: $entries->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default">
  <div class="container">
    <div class="row row-30">
      @if ($entries->count())
          @foreach ($entries as $entryDetail)
          <div class="col-sm-6 col-lg-4">
          {{-- Render entry single --}}
          @include($sc_templatePath.'.common.entry_single', ['entry' => $entryDetail])
          {{-- //Render entry single --}}
          </div>
          @endforeach

      {{-- Render pagination --}}
      @include($sc_templatePath.'.common.pagination', ['items' => $entries])
      {{--// Render pagination --}}

      @else
          {!! sc_language_render('front.no_item') !!}
      @endif
    </div>

  </div>
</section>

   {{-- Render include view --}}
   @include($sc_templatePath.'.common.include_view')
   {{--// Render include view --}}

@endsection


@push('scripts')
  {{-- Script here --}}
@endpush
