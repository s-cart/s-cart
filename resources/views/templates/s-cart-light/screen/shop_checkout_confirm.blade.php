@php
/*
$layout_page = shop_checkout
**Variables:**
- $cart: no paginate
- $shippingMethod: string
- $paymentMethod: string
- $dataTotal: array
- $shippingAddress: array
- $attributesGroup: array
- $products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default text-md-left">
    <div class="container">
        <div class="row">
            @if (count($cart) ==0)
            <div class="col-md-12 text-danger min-height-37vh">
                {!! sc_language_render('cart.cart_empty') !!}
            </div>
            @else
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table box table-bordered">
                        <thead>
                            <tr style="background: #eaebec">
                                <th style="width: 50px;">No.</th>
                                <th style="width: 100px;">{{ sc_language_render('product.sku') }}</th>
                                <th>{{ sc_language_render('product.name') }}</th>
                                <th>{{ sc_language_render('product.price') }}</th>
                                <th>{{ sc_language_render('product.quantity') }}</th>
                                <th>{{ sc_language_render('product.subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($cart as $item)
                                @php
                                    $n = (isset($n)?$n:0);
                                    $n++;
                                    $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                                @endphp

                                {{-- Render product in cart --}}
                                <tr class="row_cart">
                                    <td>{{ $n }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>
                                        {{ $product->name }}<br>
                                        {{-- Process attributes --}}
                                        @if ($item->options->count())
                                        (
                                        @foreach ($item->options as $keyAtt => $att)
                                        <b>{{ $attributesGroup[$keyAtt] }}</b>: {!! sc_render_option_price($att) !!}
                                        @endforeach
                                        )<br>
                                        @endif
                                        {{-- //end Process attributes --}}
                                        <a href="{{$product->getUrl() }}"><img width="100"
                                                src="{{sc_file($product->getImage())}}" alt=""></a>
                                    </td>
                                    <td>{!! $product->showPrice() !!}</td>
                                    <td>{{$item->qty}}</td>
                                    <td align="right">{{sc_currency_render($item->subtotal)}}</td>
                                </tr>
                                {{--// Render product in cart --}}

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12">
                <form class="sc-shipping-address" id="form-order" role="form" method="POST" action="{{ sc_route('order.add') }}">
                    {{-- Required csrf for secirity --}}
                    @csrf
                    {{--// Required csrf for secirity --}}
                    <div class="row">
                        {{-- Display address --}}
                        <div class="col-12 col-sm-12 col-md-6">
                            <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i>
                                {{ sc_language_render('cart.shipping_address') }}:<br></h3>
                            <table class="table box table-bordered" id="showTotal">
                                <tr>
                                    <th>{{ sc_language_render('order.name') }}:</td>
                                    <td>{{ $shippingAddress['first_name'] }} {{ $shippingAddress['last_name'] }}</td>
                                </tr>
                                @if (sc_config('customer_name_kana'))
                                    <tr>
                                        <th>{{ sc_language_render('order.name_kana') }}:</td>
                                        <td>{{ $shippingAddress['first_name_kana'].$shippingAddress['last_name_kana'] }}</td>
                                    </tr>
                                @endif

                                @if (sc_config('customer_phone'))
                                    <tr>
                                        <th>{{ sc_language_render('order.phone') }}:</td>
                                        <td>{{ $shippingAddress['phone'] }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>{{ sc_language_render('order.email') }}:</td>
                                    <td>{{ $shippingAddress['email'] }}</td>
                                </tr>
                                <tr>
                                    <th>{{ sc_language_render('order.address') }}:</td>
                                    <td>{{ $shippingAddress['address1'].' '.$shippingAddress['address2'].' '.$shippingAddress['address3'].','.$shippingAddress['country'] }}
                                    </td>
                                </tr>
                                @if (sc_config('customer_postcode'))
                                    <tr>
                                        <th>{{ sc_language_render('order.postcode') }}:</td>
                                        <td>{{ $shippingAddress['postcode']}}</td>
                                    </tr>
                                @endif

                                @if (sc_config('customer_company'))
                                    <tr>
                                        <th>{{ sc_language_render('order.company') }}:</td>
                                        <td>{{ $shippingAddress['company']}}</td>
                                    </tr>
                                @endif

                                <tr>
                                    <th>{{ sc_language_render('cart.note') }}:</td>
                                    <td>{{ $shippingAddress['comment'] }}</td>
                                </tr>
                            </table>
                        </div>
                        {{--// Display address --}}

                        <div class="col-12 col-sm-12 col-md-6">
                            {{-- Total --}}
                            <h3 class="control-label"><br></h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table box table-bordered" id="showTotal">
                                        @foreach ($dataTotal as $key => $element)
                                        @if ($element['code']=='total')
                                        <tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
                                            <th>{!! $element['title'] !!}</th>
                                            <td style="text-align: right" id="{{ $element['code'] }}">
                                                {{$element['text'] }}
                                            </td>
                                        </tr>
                                        @elseif($element['value'] !=0)
                                        <tr class="showTotal">
                                            <th>{!! $element['title'] !!}</th>
                                            <td style="text-align: right" id="{{ $element['code'] }}">
                                                {{$element['text'] }}
                                            </td>
                                        </tr>
                                        @elseif($element['code'] =='shipping')
                                        <tr class="showTotal">
                                            <th>{!! $element['title'] !!}</th>
                                            <td style="text-align: right" id="{{ $element['code'] }}">
                                                {{$element['text'] }}
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>

@if (!sc_config('payment_off'))
                                    {{-- Payment method --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h3 class="control-label"><i class="fas fa-credit-card"></i>
                                                    {{ sc_language_render('order.payment_method') }}:<br></h3>
                                            </div>
                                            <div class="form-group">
                                                <div>
                                                    <label class="radio-inline">
                                                        <img title="{{ $paymentMethodData['title'] }}"
                                                            alt="{{ $paymentMethodData['title'] }}"
                                                            src="{{ sc_file($paymentMethodData['image']) }}"
                                                            style="width: 120px;">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- //Payment method --}}
@endif

                                </div>
                            </div>
                            {{-- End total --}}

                            {{-- Button process cart --}}
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-md-12 text-center">
                                    <div class="pull-left">
                                        <button class="button button-lg" type="button"
                                            style="cursor: pointer;padding:10px 30px"
                                            onClick="location.href='{{ sc_route('cart') }}'"><i
                                                class="fa fa-arrow-left"></i> {{ sc_language_render('cart.back_to_cart') }}</button>
                                    </div>
                                    <div class="pull-right">
                                        <button class="button button-lg button-secondary" id="submit-order" type="submit"
                                            style="cursor: pointer;padding:10px 30px"><i class="fa fa-check"></i> {{ sc_language_render('cart.confirm') }}</button>
                                    </div>
                                </div>
                            </div>
                            {{--// Button process cart --}}

                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection



@push('scripts')
{{-- //script here --}}
@endpush

@push('styles')
{{-- Your css style --}}
@endpush