@php
/*
$layout_page = shop_page
**Variables:**
- $page: no paginate
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {!! sc_html_render($page->content) !!}
            </div>
        </div>
    </div>
</section>

   {{-- Render include view --}}
   @include($sc_templatePath.'.common.include_view')
   {{--// Render include view --}}

@endsection


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush