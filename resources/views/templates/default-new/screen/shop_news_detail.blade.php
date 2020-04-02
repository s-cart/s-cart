@php
/*
$layout_page = news_detail
$news: no paginate
*/
@endphp

@extends($templatePath.'.layout')

@section('main')
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="title-page">{{ $title }}</h1>
            </div>
            <div class="col-12 new-detail">
                {!! sc_html_render($news->content) !!}
            </div>
        </div>
    </div>
</section>

@endsection

@section('breadcrumb')
<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
    </ol>
</div>
@endsection
