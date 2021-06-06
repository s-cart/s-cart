@php
/*
$layout_page = shop_cart
**Variables:**
- $cart: no paginate
- $countries: array
- $attributesGroup: array
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default text-md-left">
    <div class="container">
        <div class="row">
            @if (count($cart) ==0)

            <div class="col-md-12">
                {!! sc_language_render('cart.cart_empty') !!}!
            </div>

            @else
            @php
                $cartTmp = $cart->groupBy('storeId');
            @endphp

            {{-- Render cart item for earch shop --}}
            @foreach ($cartTmp as $sId => $cartItem)
            <div class="col-md-12">
                <h5><i class="fa fa-shopping-bag" aria-hidden="true"></i>  {{ sc_store('title', $sId) }}</h5>
            </div>

            <div class="col-md-12">
                <form action="{{ sc_route('checkout.prepare') }}" method="POST">
                    <input type="hidden" name="store_id" value="{{ $sId }}">
                    @csrf

                    {{-- Item cart detail --}}
                    @includeIf($sc_templatePath.'.common.cart_list', ['cartItem' => $cartItem])
                    {{-- //Item cart detail --}}
                    
                    {{-- Button checkout --}}
                    <div class="col-md-12 text-center">
                        <div class="pull-right">
                            <button class="button button-lg button-secondary" type="submit">{{ sc_language_render('cart.checkout') }}</button>
                        </div>
                    </div>
                    {{-- Button checkout --}}
                </form>
            </div>
            @endforeach
            {{--// Render cart item for earch shop --}}
            @endif
        </div>
    </div>
</section>

{{-- Render include view --}}
@if (!empty($layout_page && $includePathView = config('sc_include_view.'.$layout_page, [])))
@foreach ($includePathView as $view)
   @includeIf($view)
@endforeach
@endif
{{--// Render include view --}}

@endsection



@push('scripts')

{{-- Render include script --}}
@if (!empty($layout_page) && $includePathScript = config('sc_include_script.'.$layout_page, []))
@foreach ($includePathScript as $script)
   @includeIf($script)
@endforeach
@endif
{{--// Render include script --}}

<script type="text/javascript">
    function updateCart(obj){
        let new_qty = obj.val();
        let storeId = obj.data('store_id');
        let rowid = obj.data('rowid');
        let id = obj.data('id');
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
                storeId: storeId,
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
</script>
@endpush

@push('styles')
{{-- Your css style --}}
@endpush