@php
/*
$layout_page = shop_item_list
**Variables:**
- $itemsList: paginate
Use paginate: $itemsList->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<h6 class="aside-title">{{ $title }}</h6>
<section class="section section-xl bg-default">
    <div class="container">
      <div class="row row-30">
        @if ($itemsList->count())
            @foreach ($itemsList as $item)
            <div class="col-sm-6 col-lg-4 text-center">
                {{-- Render item single --}}
                @include($sc_templatePath.'.common.item_single', ['item' => $item])               
                {{-- //Render item single --}}
              </div>
            @endforeach

        {{-- Render pagination --}}
        @include($sc_templatePath.'.common.pagination', ['items' => $itemsList])
        {{--// Render pagination --}}

        @else
            {!! sc_language_render('front.data_notfound') !!}
        @endif
      </div>
    </div>
  </section>
@endsection

@push('scripts')
{{-- //script here --}}
@endpush

@push('styles')
{{-- Your css style --}}
@endpush