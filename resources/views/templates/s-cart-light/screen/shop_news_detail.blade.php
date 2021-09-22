@php
/*
$layout_page = shop_news_detail
**Variables:**
- $news: no paginate
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {!! sc_html_render($news->content) !!}
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
