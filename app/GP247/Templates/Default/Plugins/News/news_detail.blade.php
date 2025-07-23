@php
/*
$layout_page = news_detail
**Variables:**
- $newsContent: no paginate
*/
@endphp

@extends($GP247TemplatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {!! gp247_html_render($newsContent->content) !!}
            </div>
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
