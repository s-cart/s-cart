@php
/*
$layout_page = shop_cart
*/
@endphp

@extends($templatePath.'.layout')

@section('main')
<section>
    <div class="container">
        <div class="row min-height-37vh">
            <div class="col-md-12">
                <h2 class="title-page">{{ $title }}</h2>
            </div>
            <div class="col-md-12 text-success">
                <h2>{{ trans('order.success.msg') }}</h2>
                <h3>{{ trans('order.success.order_info',['order_id'=>session('orderID')]) }}</h3>
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