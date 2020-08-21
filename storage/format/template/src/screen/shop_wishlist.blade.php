@php
/*
$layout_page = shop_cart
$wishlist: no paginate
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')

<div class="features_items">
<h2 class="title text-center">{{ $title }}</h2>
@if (count($wishlist) ==0)
    <div class="col-md-12 text-danger">
       {!! trans('front.empty_product') !!}
    </div>
@else
<div class="table-responsive">
<table class="table box table-bordered">
    <thead>
      <tr  style="background: #eaebec">
        <th style="width: 50px;">No.</th>
        <th style="width: 100px;">SKU</th>
        <th>{{ trans('product.name') }}</th>
        <th>{{ trans('product.price') }}</th>
        <th>{{ trans('cart.delete') }}</th>
      </tr>
    </thead>
    <tbody>
    @foreach($wishlist as $item)
        @php
            $n = (isset($n)?$n:0);
            $n++;
            $product = $modelProduct->start()->getDetail($item->id);
        @endphp
    <tr class="row_cart">
        <td >{{ $n }}</td>
        <td>{{ $product->sku }}</td>
        <td>
            {{ $product->name }}<br>
            <a href="{{ $product->getUrl() }}"><img width="100" src="{{asset($product->getImage())}}" alt=""></a>
        </td>
        <td>{!! $product->showPrice() !!}</td>
        <td>
            <a onClick="return confirm('Confirm')" title="Remove Item" alt="Remove Item" class="cart_quantity_delete" href="{{ sc_route('wishlist.remove',['id'=>$item->rowId]) }}"><i class="fa fa-times"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
  </table>
  </div>
@endif
            </div>

@endsection

@section('breadcrumb')
    <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection

@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
      {{-- script --}}
@endpush