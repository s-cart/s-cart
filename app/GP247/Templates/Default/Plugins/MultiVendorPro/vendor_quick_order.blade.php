@php
/*
$layout_page = vendor_quick_order
*/ 
@endphp

@extends($GP247TemplatePath.'.layout')
@php
$productsQuickOrder = $modelProduct->start()->getProductSingle()->setStore($storeId)->getData();
@endphp

@section('block_main')
<section class="page-section">
      <!-- New Products-->
        <div class="container">
          <div class="row row-30 row-lg-50">
            <form class="cart-table" method="POST" action="">
              @csrf
              <table class="quick-table table box table-bordered">
                <thead>
                  <tr>
                    <th>N.o</th>
                    <th>Image</th>
                    <th>{{ gp247_language_render('product.name') }}
                    <th>{{ gp247_language_render('order.qty') }}
                    <th>{{ gp247_language_render('order.total') }}
                  </tr>
                </thead>
                <tbody>
                  @foreach ($productsQuickOrder as $key => $productQuickOrder)
                  <tr>
                    <input type="hidden" name="cart[product_id][]" value="{{ $productQuickOrder->id }}">
                    <input type="hidden" name="cart[storeId][]" value="{{ $storeId }}">
                    <input type="hidden" id="quick-price-{{ $key }}" value="{{ $productQuickOrder->getFinalPrice() }}">
                    <td>{{ ($key + 1) }}</td>
                    <td class="quick-thumb"><img src="{{ gp247_file($productQuickOrder->getThumb()) }}"></td>
                    <td class="quick-name">
                      <a target=_new href="{{ $productQuickOrder->getUrl() }}">{{ $productQuickOrder->getName() }}</a><br>
                      SKU: {{ $productQuickOrder->sku }}<br>
                      {{ gp247_language_render('product.stock') }}: {{ $productQuickOrder->stock }}
                      {!! $productQuickOrder->showPrice() !!}
                    </td>
                    <td><input class="conform-control quick-input" data-key="{{ $key }}" name="cart[qty][]" type="number" value="0" min="0"></td>
                    <td class="quick-total" id="quick-total-{{ $key }}">0</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <td></td>
                  <td></td>
                  <td></td>
                  <th id="quick-sum-qty">0</th>
                  <th id="quick-sum-total">0</th>
                </tfoot>
              </table>
              <button class="button button-lg button-primary" type="submit">{{ gp247_language_render('action.add_to_cart') }}</button>
              </form>
          </div>
        </div>
</section>
@endsection


@push('styles')
<style>
  .quick-thumb img {
    max-width:80px  !important;
    max-height:80px  !important;
  }
  .quick-input {
    width:100px !important;
  }
  .quick-table, .cart-table {
    width: 100% !important;
  }
  .quick-name {
    font-size: 12px !important;
  }
</style>
@endpush

@push('scripts')
<script>
  $('.quick-input').change(function(){
    var row_key = $(this).data("key");
    var row_qty = $(this).val();
    var row_price = $('#quick-price-'+row_key).val();
    var row_total = row_price * row_qty;
    $('#quick-total-'+row_key).html(row_total);
    var sum_qty = 0;
    var sum_total = 0;
    $('.cart-table .quick-input').each(function(){
      sum_qty += parseFloat($(this).val());  // Or this.innerHTML, this.innerText
    });
    $('.cart-table .quick-total').each(function(){
      sum_total += parseFloat($(this).text());  // Or this.innerHTML, this.innerText
    });
    $('#quick-sum-qty').html(sum_qty);
    $('#quick-sum-total').html(sum_total);
  });
</script>
@endpush
