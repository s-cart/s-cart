@php
/*
$layout_page = front_news_detail
**Variables:**
- $news: no paginate
*/
@endphp

@extends($GP247TemplatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {!! gp247_html_render($news->content) !!}
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
