@php
/*
$layout_page = shop_wishlist
**Variables:**
- $wishlist: no paginate
*/
@endphp
@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">
    <h6 class="aside-title">{{ $title }}</h6>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-danger">
                @if (count($wishlist) ==0)
                    {{ trans('front.empty_product') }}
                @else
                <div class="table-responsive">
                    <table class="table box table-bordered">
                        <thead>
                            <tr style="background: #eaebec">
                                <th style="width: 50px;">No.</th>
                                <th style="width: 100px;">SKU</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wishlist as $item)
                            @php
                            $n = (isset($n)?$n:0);
                            $n++;
                            $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                            @endphp
                            <tr class="row_cart">
                                <td>{{ $n }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>
                                    <a href="{{$product->getUrl() }}" class="row_cart-name">
                                        <img width="100" src="{{asset($product->getImage())}}" alt="{{ $product->name }}">
                                        <span>
                                            {{ $product->name }}<br />
                                            {{-- Process attributes --}}
                                            @if ($item->options->count())
                                            (
                                            @foreach ($item->options as $keyAtt => $att)
                                            <b>{{ $attributesGroup[$keyAtt] }}</b>: <i>{{ $att }}</i> ;
                                            @endforeach
                                            )<br>
                                            @endif
                                            {{-- //end Process attributes --}}
                                        </span>
                                    </a>
                                </td>
                                <td>{!! $product->showPrice() !!}</td>
                                <td>
                                    <a onClick="return confirm('Confirm')" title="Remove Item" alt="Remove Item"
                                        class="cart_quantity_delete" href="{{ sc_route('cart.remove', ['id'=>$item->rowId, 'instance' => 'wishlist']) }}"><i
                                            class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Render block include view --}}
@if ($includePathView = config('sc_include_view.shop_wishlist', []))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render block include view --}}

@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
  {{-- Render block include script --}}
  @if ($includePathScript = config('sc_include_script.shop_wishlist', []))
  @foreach ($includePathScript as $script)
    @if (view()->exists($script))
      @include($script)
    @endif
  @endforeach
  @endif
  {{--// Render block include script --}}
@endpush