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
<section>
    <div class="container">
      <div class="row">
<h2 class="title text-center">{{ $title }}</h2>
@if (count($cart) ==0)
    <div class="col-md-12 text-danger">
        {!! trans('cart.cart_empty') !!}!
    </div>
@else
 
<div class="table-responsive">
<table class="table box table-bordered">
    <thead>
      <tr  style="background: #eaebec">
        <th style="width: 50px;">No.</th>
        <th style="width: 100px;">{{ trans('product.sku') }}</th>
        <th>{{ trans('product.name') }}</th>
        <th>{{ trans('product.price') }}</th>
        <th >{{ trans('product.quantity') }}</th>
        <th>{{ trans('product.total_price') }}</th>
        <th>{{ trans('cart.delete') }}</th>
      </tr>
    </thead>
    <tbody>

    @foreach($cart as $item)
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
{{-- Process attributes --}}
                @if ($item->options->count())
                    (
                    @foreach ($item->options as $keyAtt => $att)
                        <b>{{ $attributesGroup[$keyAtt] }}</b>: <i>{{ $att }}</i> ;
                    @endforeach
                    )<br>
                @endif
{{-- //end Process attributes --}}
            <a href="{{$product->getUrl() }}"><img width="100" src="{{asset($product->getImage())}}" alt=""></a>
        </td>
        <td>{!! $product->showPrice() !!}</td>
        <td><input style="width: 70px;" type="number" data-id="{{ $item->id }}" data-rowid="{{$item->rowId}}" onChange="updateCart($(this));" class="item-qty" name="qty-{{$item->id}}" value="{{$item->qty}}"><span class="text-danger item-qty-{{$item->id}}" style="display: none;"></span></td>
        <td align="right">{{sc_currency_render($item->subtotal)}}</td>
        <td>
            <a onClick="return confirm('Confirm?')" title="Remove Item" alt="Remove Item" class="cart_quantity_delete" href="{{route("cart.remove",['id'=>$item->rowId])}}"><i class="fa fa-times" aria-hidden="true"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr  style="background: #eaebec">
            <td colspan="7">
                 <div class="pull-left">
                <button class="btn btn-default" type="button" style="cursor: pointer;padding:10px 30px" onClick="location.href='{{ sc_route('home') }}'"><i class="fa fa-arrow-left"></i> {{ trans('cart.back_to_shop') }}</button>
                </div>
                 <div class="pull-right">
                <button class="btn" type="button" style="cursor: pointer;padding:10px 30px" onClick="if(confirm('Confirm ?')) window.location.href='{{ sc_route('cart.clear') }}';" >
                    <i class="fa fa-window-close" aria-hidden="true"></i>
                    {{ trans('cart.remove_all') }}</button>
                </div>
            </td>
        </tr>
    </tfoot>
  </table>
  </div>

<form class="sc-shipping-address" id="form-order" role="form" method="POST" action="{{ sc_route('cart.process') }}">
<div class="row">
    <div class="col-md-6">
            @csrf
            <table class="table  table-bordered table-responsive">
                <tr>
                @if (sc_config('customer_lastname'))
                    <td class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <label for="phone" class="control-label"><i class="fa fa-user"></i> {{ trans('cart.first_name') }}:</label> 
                        <input name="first_name" type="text" placeholder="{{ trans('cart.first_name') }}" value="{{(old('first_name'))?old('first_name'):$shippingAddress['first_name']}}">
                            @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                            @endif
                    </td>
                    <td class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label for="phone" class="control-label"><i class="fa fa-user"></i> {{ trans('cart.last_name') }}:</label> 
                        <input name="last_name" type="text" placeholder="{{ trans('cart.last_name') }}" value="{{(old('last_name'))?old('last_name'):$shippingAddress['last_name']}}">
                            @if($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                            @endif
                    </td> 

                @else
                <td colspan="2" class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="phone" class="control-label"><i class="fa fa-user"></i> {{ trans('cart.name') }}:</label> 
                    <input name="first_name" type="text" placeholder="{{ trans('cart.name') }}" value="{{(old('first_name'))?old('first_name'):$shippingAddress['first_name']}}">
                    @if($errors->has('first_name'))
                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
                </td>
                @endif
                </tr>

                <tr>
                    @if (sc_config('customer_phone'))
                    <td  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label"><i class="fa fa-envelope"></i> {{ trans('cart.email') }}:</label> 
                        <input name="email" type="text" placeholder="{{ trans('cart.email') }}" value="{{(old('email'))?old('email'):$shippingAddress['email']}}">
                            @if($errors->has('email'))
                                <span class="help-block">{{ $errors->first('email') }}</span>
                            @endif
                    </td>
                    <td class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone" class="control-label"><i class="fa fa-phone" aria-hidden="true"></i> {{ trans('cart.phone') }}:</label> 
                        <input name="phone" type="text" placeholder="{{ trans('cart.phone') }}" value="{{(old('phone'))?old('phone'):$shippingAddress['phone']}}">
                        @if($errors->has('phone'))
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        @endif
                    </td>
                    @else
                    <td  colspan="2" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label"><i class="fa fa-envelope"></i> {{ trans('cart.email') }}:</label> 
                        <input name="email" type="text" placeholder="{{ trans('cart.email') }}" value="{{(old('email'))?old('email'):$shippingAddress['email']}}">
                        @if($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </td>
                    @endif

                </tr>


                @if (sc_config('customer_country'))
                    <tr>
                        <td colspan="2" class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                            <label  for="country" class="control-label"><i class="fa fa-dribbble" aria-hidden="true"></i> {{ trans('cart.country') }}:</label>
                            @php
                                $ct = (old('country'))?old('country'):$shippingAddress['country'];
                            @endphp
                            <select class="form-control country " style="width: 100%;" name="country" >
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
                        <label for="postcode" class="control-label"><i class="fa fa-tablet"></i> {{ trans('cart.postcode') }}:</label> 
                        <input name="postcode" type="text" placeholder="{{ trans('cart.postcode') }}" value="{{ (old('postcode'))?old('postcode'):$shippingAddress['postcode']}}">
                        @if($errors->has('postcode'))
                            <span class="help-block">{{ $errors->first('postcode') }}</span>
                        @endif
                    </td>
                    @endif

                    @if (sc_config('customer_company'))
                    <td class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                        <label for="company" class="control-label"><i class="fa fa-university"></i> {{ trans('cart.company') }}</label>
                        <input name="company" type="text" placeholder="{{ trans('cart.company') }}" value="{{ (old('company'))?old('company'):$shippingAddress['company']}}">
                        @if($errors->has('company'))
                        <span class="help-block">{{ $errors->first('company') }}</span>
                        @endif
                    </td>
                    @endif
                </tr>

                <tr>
                    @if (sc_config('customer_address2'))
                    <td class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">
                        <label for="address1" class="control-label"><i class="fa fa-list-ul"></i> {{ trans('cart.address1') }}:</label> 
                        <input name="address1" type="text" placeholder="{{ trans('cart.address1') }}" value="{{ (old('address1'))?old('address1'):$shippingAddress['address1']}}">
                        @if($errors->has('address1'))
                            <span class="help-block">{{ $errors->first('address1') }}</span>
                        @endif
                    </td>                    
                    <td class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                        <label for="address2" class="control-label"><i class="fa fa-list-ul"></i> {{ trans('cart.address2') }}</label>
                        <input name="address2" type="text" placeholder="{{ trans('cart.address2') }}" value="{{ (old('address2'))?old('address2'):$shippingAddress['address2']}}">
                        @if($errors->has('address2'))
                        <span class="help-block">{{ $errors->first('address2') }}</span>
                        @endif
                    </td>
                    @else
                    <td colspan="2" class="form-group {{ $errors->has('address1') ? ' has-error' : '' }}">
                        <label for="address1" class="control-label"><i class="fa fa-list-ul"></i> {{ trans('cart.address') }}:</label> 
                        <input name="address1" type="text" placeholder="{{ trans('cart.address') }}" value="{{ (old('address1'))?old('address1'):$shippingAddress['address1']}}">
                        @if($errors->has('address1'))
                            <span class="help-block">{{ $errors->first('address1') }}</span>
                        @endif
                    </td>  
                    @endif
                </tr>

                <tr>
                    <td colspan="2">
                        <label  class="control-label"><i class="fa fa-calendar-o"></i> {{ trans('cart.note') }}:</label>
                        <textarea rows="5" name="comment" placeholder="{{ trans('cart.note') }}....">{{ (old('comment'))?old('comment'):$shippingAddress['comment'] }}</textarea>
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
                    @if ($element['value'] !=0)

                     @if ($element['code']=='total')
                         <tr class="showTotal" style="background:#f5f3f3;font-weight: bold;">
                     @else
                        <tr class="showTotal">
                     @endif
                             <th>{!! $element['title'] !!}</th>
                            <td style="text-align: right" id="{{ $element['code'] }}">{{$element['text'] }}</td>
                        </tr>
                    @endif

                    @endforeach
                </table>
{{-- Total method --}}

    <div class="row">
        <div class="col-md-12">
                <div class="form-group {{ $errors->has('totalMethod') ? ' has-error' : '' }}">
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
                    <div class="form-group {{ $errors->has('shippingMethod') ? ' has-error' : '' }}">
                        <h3 class="control-label"><i class="fa fa-truck" aria-hidden="true"></i> {{ trans('cart.shipping_method') }}:<br></h3>
                        @if($errors->has('shippingMethod'))
                            <span class="help-block">{{ $errors->first('shippingMethod') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        @foreach ($shippingMethod as $key => $shipping)
                            <div>
                                <label class="radio-inline">
                                 <input type="radio" name="shippingMethod" value="{{ $shipping['key'] }}"  {{ (old('shippingMethod') == $key)?'checked':'' }} style="position: relative;" {{ ($shipping['permission'])?'':'disabled' }}>
                                 {{ $shipping['title'] }} ({{ sc_currency_render($shipping['value']) }})
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
                    <div class="form-group {{ $errors->has('paymentMethod') ? ' has-error' : '' }}">
                        <h3 class="control-label"><i class="fa fa-credit-card-alt"></i> {{ trans('cart.payment_method') }}:<br></h3>
                        @if($errors->has('paymentMethod'))
                            <span class="help-block">{{ $errors->first('paymentMethod') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        @foreach ($paymentMethod as $key => $payment)
                            <div>
                                <label class="radio-inline">
                                 <input type="radio" name="paymentMethod" value="{{ $payment['key'] }}"  {{ (old('paymentMethod') == $key)?'checked':'' }} style="position: relative;" {{ ($payment['permission'])?'':'disabled' }}>
                                 <img title="{{ $payment['title'] }}" alt="{{ $payment['title'] }}" src="{{ asset($payment['image']) }}" style="width: 120px;">
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
                        <button class="btn btn-success" id="submit-order" type="button" style="cursor: pointer;padding:10px 30px"><i class="fa fa-check"></i> {{ trans('cart.checkout') }}</button>
                    </div>
            </div>
        </div>



    </div>
</div>
</form>
@endif
        </div>
    </div>
</section>
@endsection

@section('breadcrumb')
    <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection

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

$('#submit-order').click(function(){
    $('#form-order').submit();
    $(this).prop('disabled',true);
});


</script>
@endpush

@push('styles')
      {{-- style css --}}
@endpush