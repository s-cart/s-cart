@php
/*
$layout_page = content_detail
**Variables:**
- $entry_currently: colection
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
  <section class="section section-sm section-first bg-default text-md-left">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  {!! sc_html_render($entry_currently->content) !!}
              </div>
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