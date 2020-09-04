@php
/*
$layout_page = shop_cart
$cart: no paginate
$shippingMethod: string
$paymentMethod: string
$totalMethod: array
$dataTotal: array
$shippingAddress: array
$countries: array
$attributesGroup: array
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default text-md-left">
    <div class="container">
        <div class="row">
            @if (count($cart) ==0)
            <div class="col-md-12">
                {!! trans('cart.cart_empty') !!}!
            </div>
            @else
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table box table-bordered">
                        <thead>
                            <tr style="background: #eaebec">
                                <th style="width: 50px;">No.</th>
                                <th style="width: 100px;">{{ trans('product.sku') }}</th>
                                <th>{{ trans('product.name') }}</th>
                                <th>{{ trans('product.price') }}</th>
                                <th>{{ trans('product.quantity') }}</th>
                                <th>{{ trans('product.total_price') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $item)
                            @php
                            $n = (isset($n)?$n:0);
                            $n++;
                            $product = $modelProduct->start()->getDetail($item->id);
                            @endphp
                            <tr class="row_cart form-group {{ session('arrErrorQty')[$product->id] ?? '' }}{{ (session('arrErrorQty')[$product->id] ?? 0) ? ' has-error' : '' }}">
                                <td>{{ $n }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>
                                    <a href="{{$product->getUrl() }}" class="row_cart-name">
                                        <img width="100" src="{{asset($product->getImage())}}"
                                            alt="{{ $product->name }}">
                                        <span>
                                            {{ $product->name }}<br />
                                            {{-- Process attributes --}}
                                            @if ($item->options->count())
                                            @foreach ($item->options as $groupAtt => $att)
                                            <b>{{ $attributesGroup[$groupAtt] }}</b>: {!! sc_render_option_price($att) !!}
                                            @endforeach
                                            @endif
                                            {{-- //end Process attributes --}}
                                        </span>
                                    </a>
                                </td>
                                <td>{!! $product->showPrice() !!}</td>
                                <td class="cart-col-qty">
                                    <div class="cart-qty">
                                        <input style="width: 150px; margin: 0 auto" type="number" data-id="{{ $item->id }}"
                                            data-rowid="{{$item->rowId}}" onChange="updateCart($(this));"
                                            class="item-qty form-control" name="qty-{{$item->id}}" value="{{$item->qty}}">
                                    </div>
                                    <span class="text-danger item-qty-{{$item->id}}" style="display: none;"></span>
                                    @if (session('arrErrorQty')[$product->id] ?? 0)
                                    <span class="help-block">
                                        <br>{{ trans('cart.minimum_value', ['value' => session('arrErrorQty')[$product->id]]) }}
                                    </span>
                                    @endif
                                </td>
                                <td align="right">{{sc_currency_render($item->subtotal)}}
                                </td>
                                <td align="center">
                                    <a onClick="return confirm('Confirm?')" title="Remove Item" alt="Remove Item"
                                        class="cart_quantity_delete"
                                        href="{{ sc_route("cart.remove",['id'=>$item->rowId]) }}"><i class="fa fa-times"
                                            aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="pull-left">
                    <button class="btn btn-default btn-back" type="button"
                        onClick="location.href='{{ sc_route('home') }}'"><i class="fa fa-arrow-left"></i>
                        {{ trans('cart.back_to_shop') }}</button>
                </div>
                <div class="pull-right">
                    <button class="btn btn-delete-all" type="button"
                        onClick="if(confirm('Confirm ?')) window.location.href='{{ sc_route('cart.clear') }}';">
                        <i class="fa fa-window-close" aria-hidden="true"></i>
                        {{ trans('cart.remove_all') }}</button>
                </div>
            </div>
            <div class="col-md-12">
                <form class="sc-shipping-address" id="form-order" role="form" method="POST"
                    action="{{ sc_route('cart.process') }}">
                    <div class="row">
                        <div class="col-md-6">
                            @if (auth()->user())
                            <div class="">
                                <select class="form-control" name="address_process" style="width: 100%;" id="addressList">
                                    <option value="">{{ trans('cart.change_address') }}</option>
                                    @foreach ($addressList as $k => $address)
                                    <option value="{{ $address->id }}" {{ (old('address_process') ==  $address->id) ? 'selected':''}}>- {{ $address->first_name. ' '.$address->last_name.', '.$address->address1.' '.$address->address2 }}</option>
                                    @endforeach
                                    <option value="new" {{ (old('address_process') ==  'new') ? 'selected':''}}>{{ trans('cart.add_new_address') }}</option>
                                </select>
                            </div>
                            @endif

                            @csrf
                            <table class="table table-borderless table-responsive">
                                <tr width=100%>
                                    @if (sc_config('customer_lastname'))
                                    <td class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label"><i class="fa fa-user"></i>
                                            {{ trans('cart.first_name') }}:</label>
                                        <input class="form-control" name="first_name" type="text"
                                            placeholder="{{ trans('cart.first_name') }}"
                                            value="{{old('first_name', $shippingAddress['first_name'])}}">
                                        @if($errors->has('first_name'))
                                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </td>
                                    <td class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label"><i class="fa fa-user"></i>
                                            {{ trans('cart.last_name') }}:</label>
                                        <input class="form-control" name="last_name" type="text" placeholder="{{ trans('cart.last_name') }}"
                                            value="{{old('last_name',$shippingAddress['last_name'])}}">
                                        @if($errors->has('last_name'))
                                        <span class="help-block">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </td>

                                    @else
                                    <td colspan="2"
                                        class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label"><i class="fa fa-user"></i>
                                            {{ trans('cart.name') }}:</label>
                                        <input class="form-control" name="first_name" type="text" placeholder="{{ trans('cart.name') }}"
                                            value="{{old('first_name',$shippingAddress['first_name'])}}">
                                        @if($errors->has('first_name'))
                                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </td>
                                    @endif
                                </tr>

                                @if (sc_config('customer_name_kana'))
                                <tr>
                                <td class="form-group{{ $errors->has('first_name_kana') ? ' has-error' : '' }}">
                                    <label for="phone" class="control-label"><i class="fa fa-user"></i>
                                        {{ trans('cart.first_name_kana') }}:</label>
                                    <input class="form-control" name="first_name_kana" type="text"
                                        placeholder="{{ trans('cart.first_name_kana') }}"
                                        value="{{old('first_name_kana', $shippingAddress['first_name_kana'])}}">
                                    @if($errors->has('first_name_kana'))
                                    <span class="help-block">{{ $errors->first('first_name_kana') }}</span>
                                    @endif
                                </td>
                                <td class="form-group{{ $errors->has('last_name_kana') ? ' has-error' : '' }}">
                                    <label for="phone" class="control-label"><i class="fa fa-user"></i>
                                        {{ trans('cart.last_name_kana') }}:</label>
                                    <input class="form-control" name="last_name_kana" type="text" placeholder="{{ trans('cart.last_name_kana') }}"
                                        value="{{old('last_name_kana',$shippingAddress['last_name_kana'])}}">
                                    @if($errors->has('last_name_kana'))
                                    <span class="help-block">{{ $errors->first('last_name_kana') }}</span>
                                    @endif
                                </td>
                                </tr>
                                @endif

                                <tr>
                                    @if (sc_config('customer_phone'))
                                    <td class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label"><i class="fa fa-envelope"></i>
                                            {{ trans('cart.email') }}:</label>
                                        <input class="form-control" name="email" type="text" placeholder="{{ trans('cart.email') }}"
                                            value="{{old('email', $shippingAddress['email'])}}">
                                        @if($errors->has('email'))
                                        <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </td>
                                    <td class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label for="phone" class="control-label"><i class="fa fa-phone"
                                                aria-hidden="true"></i> {{ trans('cart.phone') }}:</label>
                                        <input class="form-control" name="phone" type="text" placeholder="{{ trans('cart.phone') }}"
                                            value="{{old('phone',$shippingAddress['phone'])}}">
                                        @if($errors->has('phone'))
                                        <span class="help-block">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </td>
                                    @else
                                    <td colspan="2" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label"><i class="fa fa-envelope"></i>
                                            {{ trans('cart.email') }}:</label>
                                        <input class="form-control" name="email" type="text" placeholder="{{ trans('cart.email') }}"
                                            value="{{old('email',$shippingAddress['email'])}}">
                                        @if($errors->has('email'))
                                        <span class="help-block">{{ $errors->first('email') }}</span>
                                        @endif
                                    </td>
                                    @endif

                                </tr>


                                @if (sc_config('customer_country'))
                                <tr>
                                    <td colspan="2" class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                        <label for="country" class="control-label"><i class="fas fa-globe"></i>
                                            {{ trans('cart.country') }}:</label>
                                        @php
                                        $ct = old('country',$shippingAddress['country']);
                                        @endphp
                                        <select class="form-control country " style="width: 100%;" name="country">
                                            <option value="">__{{ trans('cart.country') }}__</option>
                                            @foreach ($countries as $k => $v)
                                            <option value="{{ $k }}" {{ ($ct ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                        <span class="help-block">
                                            {{ $errors->first('country') }}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endif


                                <tr>
                                    @if (sc_config('customer_postcode'))
                                    <td class="form-group {{ $errors->has('postcode') ? ' has-error' : '' }}">
                                        <label for="postcode" class="control-label"><i class="fa fa-tablet"></i>
                                            {{ trans('cart.postcode') }}:</label>
                                        <input class="form-control" name="postcode" type="text" placeholder="{{ trans('cart.postcode') }}"
                                            value="{{ old('postcode',$shippingAddress['postcode'])}}">
                                        @if($errors->has('postcode'))
                                        <span class="help-block">{{ $errors->first('postcode') }}</span>
                                        @endif
                                    </td>
                                    @endif

                                    @if (sc_config('customer_company'))
                                    <td class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                        <label for="company" class="control-label"><i class="fa fa-university"></i>
                                            {{ trans('cart.company') }}</label>
                                        <input class="form-control" name="company" type="text" placeholder="{{ trans('cart.company') }}"
                                            value="{{ old('company',$shippingAddress['company'])}}">
                                        @if($errors->has('company'))
                                        <span class="help-block">{{ $errors->first('company') }}</span>
                                        @endif
                                    </td>
                                    @endif
                                </tr>

                                <tr>
                                    @if (sc_config('customer_address2'))
                                    <td class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">
                                        <label for="address1" class="control-label"><i class="fa fa-list-ul"></i>
                                            {{ trans('cart.address1') }}:</label>
                                        <input class="form-control" name="address1" type="text" placeholder="{{ trans('cart.address1') }}"
                                            value="{{ old('address1',$shippingAddress['address1'])}}">
                                        @if($errors->has('address1'))
                                        <span class="help-block">{{ $errors->first('address1') }}</span>
                                        @endif
                                    </td>
                                    <td class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
                                        <label for="address2" class="control-label"><i class="fa fa-list-ul"></i>
                                            {{ trans('cart.address2') }}</label>
                                        <input class="form-control" name="address2" type="text" placeholder="{{ trans('cart.address2') }}"
                                            value="{{ old('address2',$shippingAddress['address2'])}}">
                                        @if($errors->has('address2'))
                                        <span class="help-block">{{ $errors->first('address2') }}</span>
                                        @endif
                                    </td>
                                    @else
                                        @if (sc_config('customer_address1'))
                                        <td colspan="2"
                                            class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">
                                            <label for="address1" class="control-label"><i class="fa fa-list-ul"></i>
                                                {{ trans('cart.address') }}:</label>
                                            <input class="form-control" name="address1" type="text" placeholder="{{ trans('cart.address') }}"
                                                value="{{ old('address1',$shippingAddress['address1'])}}">
                                            @if($errors->has('address1'))
                                            <span class="help-block">{{ $errors->first('address1') }}</span>
                                            @endif
                                        </td>
                                        @endif
                                    @endif
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        <label class="control-label"><i class="fa fa-calendar-o"></i>
                                            {{ trans('cart.note') }}:</label>
                                        <textarea class="form-control" rows="5" name="comment"
                                            placeholder="{{ trans('cart.note') }}....">{{ old('comment','')}}</textarea>
                                    </td>
                                </tr>


                            </table>

                        </div>
                        <div class="col-md-6">
                            {{-- Total --}}
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
                                        @endif
                                        @endforeach
                                    </table>

                                    {{-- Total method --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div
                                                class="form-group {{ $errors->has('totalMethod') ? ' has-error' : '' }}">
                                                @if($errors->has('totalMethod'))
                                                <span class="help-block">{{ $errors->first('totalMethod') }}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                @foreach ($totalMethod as $key => $plugin)
                                                @if (view()->exists($plugin['pathPlugin'].'::render'))
                                                @include($plugin['pathPlugin'].'::render')
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    {{-- //Total method --}}


                                    {{-- Shipping method --}}

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div
                                                class="form-group {{ $errors->has('shippingMethod') ? ' has-error' : '' }}">
                                                <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i>
                                                    {{ trans('cart.shipping_method') }}:<br></h3>
                                                @if($errors->has('shippingMethod'))
                                                <span class="help-block">{{ $errors->first('shippingMethod') }}</span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                @foreach ($shippingMethod as $key => $shipping)
                                                <div>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="shippingMethod"
                                                            value="{{ $shipping['key'] }}"
                                                            {{ (old('shippingMethod') == $key)?'checked':'' }}
                                                            style="position: relative;"
                                                            {{ ($shipping['permission'])?'':'disabled' }}>
                                                        {{ $shipping['title'] }}
                                                        ({{ sc_currency_render($shipping['value']) }})
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    {{-- //Shipping method --}}


                                    {{-- Payment method --}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div
                                                class="form-group {{ $errors->has('paymentMethod') ? ' has-error' : '' }}">
                                                <h3 class="control-label"><i class="fa fa-credit-card-alt"></i>
                                                    {{ trans('cart.payment_method') }}:<br></h3>
                                                @if($errors->has('paymentMethod'))
                                                <span class="help-block">{{ $errors->first('paymentMethod') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group cart-payment-method">
                                                @foreach ($paymentMethod as $key => $payment)
                                                <div>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="paymentMethod"
                                                            value="{{ $payment['key'] }}"
                                                            {{ (old('shippingMethod') == $key)?'checked':'' }}
                                                            style="position: relative;"
                                                            {{ ($payment['permission'])?'':'disabled' }}>
                                                            <label class="radio-inline" for="payment-{{ $payment['key'] }}">
                                                                <img title="{{ $payment['title'] }}"
                                                                    alt="{{ $payment['title'] }}"
                                                                    src="{{ asset($payment['image']) }}">
                                                            </label>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    {{-- //Payment method --}}
                                </div>
                            </div>
                            {{-- End total --}}
                            <div class="row" style="padding-bottom: 20px;">
                                <div class="col-md-12 text-center">
                                    <div class="pull-right">
                                        <button class="button button-lg button-secondary" type="submit" id="submit-order" href="cart-page.html">{{ trans('cart.checkout') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</section>
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


@push('scripts')
<script type="text/javascript">
    @foreach ($totalMethod as $key => $plugin)
        @if (view()->exists($plugin['pathPlugin'].'::script'))
            @include($plugin['pathPlugin'].'::script')
        @endif
    @endforeach

    function updateCart(obj){
        var new_qty = obj.val();
        var rowid = obj.data('rowid');
        var id = obj.data('id');
        $.ajax({
            url: '{{ sc_route('cart.update') }}',
            type: 'POST',
            dataType: 'json',
            async: false,
            cache: false,
            data: {
                id: id,
                rowId: rowid,
                new_qty: new_qty,
                _token:'{{ csrf_token() }}'},
            success: function(data){
                error= parseInt(data.error);
                if(error ===0)
                {
                        window.location.replace(location.href);
                }else{
                    $('.item-qty-'+id).css('display','block').html(data.msg);
                }

                }
        });
    }

    function buttonQty(obj, action){
        var parent = obj.parent();
        var input = parent.find(".item-qty");
        if(action === 'reduce'){
            input.val(parseInt(input.val()) - 1);
        }else{
            input.val(parseInt(input.val()) + 1);
        }
        updateCart(input)
    }

    $('#submit-order').click(function(){
        $('#form-order').submit();
        $(this).prop('disabled',true);
    });

    $('#addressList').change(function(){
        var id = $('#addressList').val();
        if(!id) {
            return;   
        } else if(id == 'new') {
            $('#form-order [name="first_name"]').val('');
            $('#form-order [name="last_name"]').val('');
            $('#form-order [name="phone"]').val('');
            $('#form-order [name="postcode"]').val('');
            $('#form-order [name="company"]').val('');
            $('#form-order [name="country"]').val('');
            $('#form-order [name="address1"]').val('');
            $('#form-order [name="address2"]').val('');
        } else {
            $.ajax({
            url: '{{ sc_route('member.address_detail') }}',
            type: 'POST',
            dataType: 'json',
            async: false,
            cache: false,
            data: {
                id: id,
                _token:'{{ csrf_token() }}'},
            success: function(data){
                error= parseInt(data.error);
                if(error === 1)
                {
                    alert(data.msg);
                }else{
                    $('#form-order [name="first_name"]').val(data.first_name);
                    $('#form-order [name="last_name"]').val(data.last_name);
                    $('#form-order [name="phone"]').val(data.phone);
                    $('#form-order [name="postcode"]').val(data.postcode);
                    $('#form-order [name="company"]').val(data.company);
                    $('#form-order [name="country"]').val(data.country);
                    $('#form-order [name="address1"]').val(data.address1);
                    $('#form-order [name="address2"]').val(data.address2);
                }

                }
        });
        }
    });

</script>
@endpush
