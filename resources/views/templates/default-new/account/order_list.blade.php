@php
/*
$layout_page = shop_profile
$statusOrder
*/ 
@endphp

@extends($templatePath.'.layout')

@section('main')
<div class="container">
  <div class="row">
    {{-- <div class="col-12">
      <h2 class="title-page">{{ trans('account.my_profile') }}</h2>
    </div> --}}
    <div class="col-12 col-sm-12 col-md-3">
      @include($templatePath.'.account.nav_customer')
    </div>
    <div class="col-12 col-sm-12 col-md-9 min-height-37vh">
      <h3 class="title-optoins-customer">{{ $title }}</h3>
      @if (count($orders) ==0)
      <div class="text-danger">
        {{ trans('account.orders.empty') }}
      </div>
      @else
      <table class="table box  table-bordered table-responsive">
        <thead>
          <tr>
            <th style="width: 50px;">No.</th>
            <th style="width: 100px;">{{ trans('account.orders.id') }}</th>
            <th>{{ trans('account.orders.total') }}</th>
            <th>{{ trans('account.orders.status') }}</th>
            <th>{{ trans('account.orders.date_add') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          @php
          $n = (isset($n)?$n:0);
          $n++;
          // $order = (new App\Models\ShopProduct)->getDetail($item->id);
          @endphp
          <tr>
            <td><span class="item_21_id">{{ $n }}</span></td>
            <td><span class="item_21_sku">#{{ $order->id }}</span></td>
            <td align="right">
              {{ number_format($order->total) }}
            </td>
            <td>{{ $statusOrder[$order->status]}}</td>
            <td>{{ $order->created_at }}</td>
            <td>
              <a href="{{ route('member.order_detail', ['id' => $order->id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ trans('account.orders.detail_order') }}</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>
</div>
@endsection

@section('breadcrumb')
<div class="breadcrumbs">
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
    <li><a href="{{ route('member.index') }}">{{ trans('front.my_account') }}</a></li>
    <li class="active">{{ $title }}</li>
  </ol>
</div>
@endsection