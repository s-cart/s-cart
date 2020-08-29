@php
/*
$layout_page = shop_cart
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">
<h6 class="aside-title">{{ $title }}</h6>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-page">{{ $title }}</h2>
        </div>
        <div class="col-md-12 text-success">
            <h2>{{ trans('order.success.msg') }}</h2>
            <h3>{{ trans('order.success.order_info',['order_id'=>session('orderID')]) }}</h3>
        </div>
    </div>
</div>
@endsection

@section('breadcrumb')
@endsection