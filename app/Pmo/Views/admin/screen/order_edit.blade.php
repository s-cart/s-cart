@extends($templatePathAdmin.'layout')

@section('main')
 <div class="row">
    <div class="col-md-12">
       <div class="card">

          <div class="card-header with-border">
              <h3 class="card-title">{{ sc_language_render('order.order_detail') }} #{{ $order->id }}</h3>
              <div class="card-tools not-print">
                  <div class="btn-group float-right" style="margin-right: 0px">
                      <a href="{{ sc_route_admin('admin_order.index') }}" class="btn btn-flat btn-default"><i class="fa fa-list"></i>&nbsp;{{ sc_language_render('admin.back_list') }}</a>
                  </div>
                  <div class="btn-group float-right" style="margin-right: 10px;border:1px solid #c5b5b5;">
                      <a class="btn btn-flat" target=_new title="Invoice" href="{{ sc_route_admin('admin_order.invoice', ['order_id' => $order->id]) }}"><i class="far fa-file-pdf"></i><span class="hidden-xs"> {{ sc_language_render('order.invoice') }}</span></a>
                  </div>
              </div>
          </div>

          <div class="row" id="order-body">
            <div class="col-sm-6">
                 <table class="table table-hover box-body text-wrap table-bordered">
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.first_name') }}:</td><td><a href="#" class="updateInfoRequired" data-name="first_name" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.first_name') }}" >{!! $order->first_name !!}</a></td>
                    </tr>

                    @if (sc_config_admin('customer_lastname'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.last_name') }}:</td><td><a href="#" class="updateInfoRequired" data-name="last_name" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.last_name') }}" >{!! $order->last_name !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_phone'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.phone') }}:</td><td><a href="#" class="updateInfoRequired" data-name="phone" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.phone') }}" >{!! $order->phone !!}</a></td>
                    </tr>
                    @endif

                    <tr>
                      <td class="td-title">{{ sc_language_render('order.email') }}:</td><td>{!! empty($order->email)?'N/A':$order->email!!}</td>
                    </tr>

                    @if (sc_config_admin('customer_company'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.company') }}:</td><td><a href="#" class="updateInfoRequired" data-name="company" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.company') }}" >{!! $order->company !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_postcode'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.postcode') }}:</td><td><a href="#" class="updateInfoRequired" data-name="postcode" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.postcode') }}" >{!! $order->postcode !!}</a></td>
                    </tr>
                    @endif

                    <tr>
                      <td class="td-title">{{ sc_language_render('order.address1') }}:</td><td><a href="#" class="updateInfoRequired" data-name="address1" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address1') }}" >{!! $order->address1 !!}</a></td>
                    </tr>

                    @if (sc_config_admin('customer_address2'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.address2') }}:</td><td><a href="#" class="updateInfoRequired" data-name="address2" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address2') }}" >{!! $order->address2 !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_address3'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.address3') }}:</td><td><a href="#" class="updateInfoRequired" data-name="address3" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address3') }}" >{!! $order->address3 !!}</a></td>
                    </tr>
                    @endif

                    @if (sc_config_admin('customer_country'))
                    <tr>
                      <td class="td-title">{{ sc_language_render('order.country') }}:</td><td><a href="#" class="updateInfoRequired" data-name="country" data-type="select" data-source ="{{ json_encode($country) }}" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.country') }}" data-value="{!! $order->country !!}"></a></td>
                    </tr>
                    @endif

                </table>
            </div>
            <div class="col-sm-6">
                <table  class="table table-bordered">
                    <tr><td  class="td-title">{{ sc_language_render('order.order_status') }}:</td><td><a href="#" class="updateStatus" data-name="status" data-type="select" data-source ="{{ json_encode($statusOrder) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.order_status') }}">{{ $statusOrder[$order->status] ?? $order->status }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.shipping_status') }}:</td><td><a href="#" class="updateStatus" data-name="shipping_status" data-type="select" data-source ="{{ json_encode($statusShipping) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->shipping_status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.shipping_status') }}">{{ $statusShipping[$order->shipping_status]??$order->shipping_status }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.payment_status') }}:</td><td><a href="#" class="updateStatus" data-name="payment_status" data-type="select" data-source ="{{ json_encode($statusPayment) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->payment_status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.payment_status') }}">{{ $statusPayment[$order->payment_status]??$order->payment_status }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.shipping_method') }}:</td><td><a href="#" class="updateStatus" data-name="shipping_method" data-type="select" data-source ="{{ json_encode($shippingMethod) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->shipping_method !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.shipping_method') }}">{{ $order->shipping_method }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.payment_method') }}:</td><td><a href="#" class="updateStatus" data-name="payment_method" data-type="select" data-source ="{{ json_encode($paymentMethod) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->payment_method !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.payment_method') }}">{{ $order->payment_method }}</a></td></tr>
                    <tr><td>{{ sc_language_render('order.domain') }}:</td><td>{{ $order->domain }}</td></tr>
                    <tr><td></i> {{ sc_language_render('admin.created_at') }}:</td><td>{{ $order->created_at }}</td></tr>
                  </table>
                 <table class="table table-hover box-body text-wrap table-bordered">
                    <tr>
                      <td class="td-title"><i class="far fa-money-bill-alt nav-icon"></i> {{ sc_language_render('order.currency') }}:</td><td>{{ $order->currency }}</td>
                    </tr>
                    <tr>
                      <td class="td-title"><i class="fas fa-chart-line"></i> {{ sc_language_render('order.exchange_rate') }}:</td><td>{{ ($order->exchange_rate)??1 }}</td>
                    </tr>
                </table>
            </div>

          </div>

@php
    if($order->balance == 0){
        $style = 'style="color:#0e9e33;font-weight:bold;"';
    }else
        if($order->balance < 0){
        $style = 'style="color:#ff2f00;font-weight:bold;"';
    }else{
        $style = 'style="font-weight:bold;"';
    }
@endphp

    <form id="form-add-item" action="" method="">
      @csrf
      <input type="hidden" name="order_id"  value="{{ $order->id }}">
      <div class="row">
        <div class="col-sm-12">
          <div class="card collapsed-card">
          <div class="table-responsive">
            <table class="table table-hover box-body text-wrap table-bordered">
                <thead>
                  <tr>
                    <th>{{ sc_language_render('product.name') }}</th>
                    <th>{{ sc_language_render('product.sku') }}</th>
                    <th class="product_price">{{ sc_language_render('product.price') }}</th>
                    <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                    <th class="product_total">{{ sc_language_render('product.total_price') }}</th>
                    <th class="product_tax">{{ sc_language_render('product.tax') }}</th>
                    <th>{{ sc_language_render('action.title') }}</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $item)
                          <tr>
                            <td>{{ $item->name }}
                              @php
                              $html = '';
                                if($item->attribute && is_array(json_decode($item->attribute,true))){
                                  $array = json_decode($item->attribute,true);
                                      foreach ($array as $key => $element){
                                        $html .= '<br><b>'.$attributesGroup[$key].'</b> : <i>'.sc_render_option_price($element, $order->currency, $order->exchange_rate).'</i>';
                                      }
                                }
                              @endphp
                            {!! $html !!}
                            </td>
                            <td>{{ $item->sku }}</td>
                            <td class="product_price"><a href="#" class="edit-item-detail" data-value="{{ $item->price }}" data-name="price" data-type="text" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('product.price') }}">{{ $item->price }}</a></td>
                            <td class="product_qty">x <a href="#" class="edit-item-detail" data-value="{{ $item->qty }}" data-name="qty" data-type="number" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('order.qty') }}"> {{ $item->qty }}</a></td>
                            <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                            <td class="product_tax"><a href="#" class="edit-item-detail" data-value="{{ $item->tax }}" data-name="tax" data-type="text" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ sc_language_render('order.tax') }}"> {{ $item->tax }}</a></td>
                            <td>
                                <span  onclick="deleteItem({{ $item->id }});" class="btn btn-danger btn-xs" data-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></span>
                            </td>
                          </tr>
                    @endforeach

                    <tr  id="add-item" class="not-print">
                      <td colspan="7">
                        <button  type="button" class="btn btn-flat btn-success" id="add-item-button"  title="{{sc_language_render('action.add') }}"><i class="fa fa-plus"></i> {{ sc_language_render('action.add') }}</button>
                        &nbsp;&nbsp;&nbsp;<button style="display: none; margin-right: 50px" type="button" class="btn btn-flat btn-warning" id="add-item-button-save"  title="Save"><i class="fa fa-save"></i> {{ sc_language_render('action.save') }}</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        </div>

      </div>
</form>

      <div class="row">
        {{-- Total --}}
          <div class="col-sm-6">
            <div class="card collapsed-card">
                <table   class="table table-bordered">
                  @foreach ($dataTotal as $element)
                    @if ($element['code'] =='subtotal')
                      <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                    @endif
                    @if ($element['code'] =='tax')
                    <tr><td  class="td-title-normal">{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                    @endif

                    @if ($element['code'] =='shipping')
                      <tr><td>{!! $element['title'] !!}:</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}"  data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.shipping') }}">{{$element['value'] }}</a></td></tr>
                    @endif
                    @if ($element['code'] =='discount')
                      <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.discount') }}">{{$element['value'] }}</a></td></tr>
                    @endif
                    @if ($element['code'] =='other_fee')
                      <tr><td>{!! $element['title'] !!}:</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ config('cart.process.other_fee.title') }}">{{$element['value'] }}</a></td></tr>
                    @endif
                     @if ($element['code'] =='total')
                      <tr style="background:#f5f3f3;font-weight: bold;"><td>{!! $element['title'] !!}:</td><td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td></tr>
                    @endif

                    @if ($element['code'] =='received')
                      <tr><td>{!! $element['title'] !!}(-):</td><td style="text-align:right"><a href="#" class="updatePrice data-{{ $element['code'] }}" data-name="{{ $element['code'] }}" data-type="text" data-pk="{{ $element['id'] }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.totals.received') }}">{{$element['value'] }}</a></td></tr>
                    @endif

                  @endforeach

                    <tr  {!! $style !!}  class="data-balance"><td>{{ sc_language_render('order.totals.balance') }}:</td><td style="text-align:right">{{($order->balance === NULL)?sc_currency_format($order->total):sc_currency_format($order->balance) }}</td></tr>
              </table>
            </div>

          </div>
          {{-- //End total --}}

          {{-- History --}}
          <div class="col-sm-6">
            <div class="card">
              <table class="table table-hover box-body text-wrap table-bordered">
                <tr>
                  <td  class="td-title">{{ sc_language_render('order.order_note') }}:</td>
                  <td>
                    <a href="#" class="updateInfo" data-name="comment" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="" >
                      {{ $order->comment }}
                    </a>
                </td>
                </tr>
              </table>
            </div>


            <div class="card collapsed-card"">
              <div class="card-header border-transparent">
                <h3 class="card-title">{{ sc_language_render('order.admin.order_history') }}</h3>
                <div class="order-info">
                  <span><b>Agent:</b> {{ $order->user_agent }}</span>
                  <span><b>IP:</b> {{ $order->ip }}</span>
                </div>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0 out">
                <div class="table-responsive">
                  @if (count($order->history))
                  <table  class="table m-0" id="history">
                    <tr>
                      <th>{{ sc_language_render('order.admin.history_staff') }}</th>
                      <th>{{ sc_language_render('order.admin.history_content') }}</th>
                      <th>{{ sc_language_render('order.admin.history_time') }}</th>
                    </tr>
                  @foreach ($order->history->sortKeysDesc()->all() as $history)
                    <tr>
                      <td>{{ \App\Pmo\Admin\Models\AdminUser::find($history['admin_id'])->name??'' }}</td>
                      <td><div class="history">{!! $history['content'] !!}</div></td>
                      <td>{{ $history['add_date'] }}</td>
                    </tr>
                  @endforeach
                  </table>
                @endif
                </div>
                <!-- /.table-responsive -->
              </div>
            </div>

          </div>
          {{-- //End history --}}
      </div>
@php
  $htmlSelectProduct = '<tr>
              <td>
                <select onChange="selectProduct($(this));"  class="add_id form-control select2" name="add_id[]" style="width:100% !important;">
                <option value="0">'.sc_language_render('order.admin.select_product').'</option>';
                if(count($products)){
                  foreach ($products as $pId => $product){
                    $htmlSelectProduct .='<option  value="'.$pId.'" >'.$product['name'].'('.$product['sku'].')</option>';
                   }
                }
  $htmlSelectProduct .='
              </select>
              <span class="add_attr"></span>
            </td>
              <td><input type="text" disabled class="add_sku form-control"  value=""></td>
              <td><input onChange="update_total($(this));" type="number" step="0.01" min="0" class="add_price form-control" name="add_price[]" value="0"></td>
              <td><input onChange="update_total($(this));" type="number" min="0" class="add_qty form-control" name="add_qty[]" value="0"></td>
              <td><input type="number" disabled class="add_total form-control" value="0"></td>
              <td><input  type="number" step="0.01" min="0" class="add_tax form-control" name="add_tax[]" value="0"></td>
              <td><button onClick="$(this).parent().parent().remove();" class="btn btn-danger btn-md btn-flat" data-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button></td>
            </tr>
          <tr>
          </tr>';
        $htmlSelectProduct = str_replace("\n", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("\t", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("\r", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("'", '"', $htmlSelectProduct);
@endphp
    </div>
  </div>
</div>
@endsection


@push('styles')
<style type="text/css">
.history{
  max-height: 50px;
  max-width: 300px;
  overflow-y: auto;
}
.td-title{
  width: 35%;
  font-weight: bold;
}
.td-title-normal{
  width: 35%;
}
.product_qty{
  width: 80px;
  text-align: right;
}
.product_price,.product_total{
  width: 120px;
  text-align: right;
}

</style>
<!-- Ediable -->
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
{{-- //Pjax --}}
<script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>



<script type="text/javascript">

function update_total(e){
    node = e.closest('tr');
    var qty = node.find('.add_qty').eq(0).val();
    var price = node.find('.add_price').eq(0).val();
    node.find('.add_total').eq(0).val(qty*price);
}


//Add item
    function selectProduct(element){
        node = element.closest('tr');
        var id = node.find('option:selected').eq(0).val();
        if(!id){
            node.find('.add_sku').val('');
            node.find('.add_qty').eq(0).val('');
            node.find('.add_price').eq(0).val('');
            node.find('.add_attr').html('');
            node.find('.add_tax').html('');
        }else{
            $.ajax({
                url : '{{ sc_route_admin('admin_order.product_info') }}',
                type : "get",
                dateType:"application/json; charset=utf-8",
                data : {
                     id : id,
                     order_id : '{{ $order->id }}',
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
                node.find('.add_sku').val(returnedData.sku);
                node.find('.add_qty').eq(0).val(1);
                node.find('.add_price').eq(0).val(returnedData.price_final * {!! ($order->exchange_rate)??1 !!});
                node.find('.add_total').eq(0).val(returnedData.price_final * {!! ($order->exchange_rate)??1 !!});
                node.find('.add_attr').eq(0).html(returnedData.renderAttDetails);
                node.find('.add_tax').eq(0).html(returnedData.tax);
                $('#loading').hide();
                }
            });
        }

    }
$('#add-item-button').click(function() {
  var html = '{!! $htmlSelectProduct !!}';
  $('#add-item').before(html);
  $('.select2').select2();
  $('#add-item-button-save').show();
});

$('#add-item-button-save').click(function(event) {
    $('#add-item-button').prop('disabled', true);
    $('#add-item-button-save').button('loading');
    $.ajax({
        url:'{{ route("admin_order.add_item") }}',
        type:'post',
        dataType:'json',
        data:$('form#form-add-item').serialize(),
        beforeSend: function(){
            $('#loading').show();
        },
        success: function(result){
          $('#loading').hide();
            if(parseInt(result.error) ==0){
                location.reload();
            }else{
              alertJs('error', result.msg);
            }
        }
    });
});

//End add item
//

$(document).ready(function() {
  all_editable();
});

function all_editable(){
    $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
    };

    $('.updateInfo').editable({
      success: function(response) {
        if(response.error ==0){
          alertJs('success', response.msg);
        } else {
          alertJs('error', response.msg);
        }
    }
    });

    $(".updatePrice").on("shown", function(e, editable) {
      var value = $(this).text().replace(/,/g, "");
      editable.input.$input.val(parseInt(value));
    });

    $('.updateStatus').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(response) {
          if(response.error ==0){
            alertJs('success', response.msg);
          } else {
            alertJs('error', response.msg);
          }
      }
    });

    $('.updateInfoRequired').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(response,newValue) {
          console.log(response.msg);
          if(response.error == 0){
            alertJs('success', response.msg);
          } else {
            alertJs('error', response.msg);
          }
      }
    });


    $('.edit-item-detail').editable({
        ajaxOptions: {
        type: 'post',
        dataType: 'json'
        },
        validate: function(value) {
          if (value == '') {
              return '{{  sc_language_render('admin.not_empty') }}';
          }
          if (!$.isNumeric(value)) {
              return '{{  sc_language_render('admin.only_numeric') }}';
          }
        },
        success: function(response,newValue) {
            if(response.error ==0){
                $('.data-shipping').html(response.detail.shipping);
                $('.data-received').html(response.detail.received);
                $('.data-subtotal').html(response.detail.subtotal);
                $('.data-tax').html(response.detail.tax);
                $('.data-total').html(response.detail.total);
                $('.data-shipping').html(response.detail.shipping);
                $('.data-discount').html(response.detail.discount);
                $('.item_id_'+response.detail.item_id).html(response.detail.item_total_price);
                var objblance = $('.data-balance').eq(0);
                objblance.before(response.detail.balance);
                objblance.remove();
                alertJs('success', response.msg);
            } else {
              alertJs('error', response.msg);
            }
        }

    });

    $('.updatePrice').editable({
        ajaxOptions: {
        type: 'post',
        dataType: 'json'
        },
        validate: function(value) {
          if (value == '') {
              return '{{  sc_language_render('admin.not_empty') }}';
          }
          if (!$.isNumeric(value)) {
              return '{{  sc_language_render('admin.only_numeric') }}';
          }
       },

        success: function(response, newValue) {
              if(response.error ==0){
                  $('.data-shipping').html(response.detail.shipping);
                  $('.data-received').html(response.detail.received);
                  $('.data-subtotal').html(response.detail.subtotal);
                  $('.data-tax').html(response.detail.tax);
                  $('.data-total').html(response.detail.total);
                  $('.data-shipping').html(response.detail.shipping);
                  $('.data-discount').html(response.detail.discount);
                  var objblance = $('.data-balance').eq(0);
                  objblance.before(response.detail.balance);
                  objblance.remove();
                  alertJs('success', response.msg);
              } else {
                alertJs('error', response.msg);
              }
      }
    });
}


{{-- sweetalert2 --}}
function deleteItem(id){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ sc_language_render('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'POST',
                url: '{{ route("admin_order.delete_item") }}',
                data: {
                  'pId':id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                  if(response.error ==0){
                    location.reload();
                    alertJs('success', response.msg);
                } else {
                  alertJs('error', response.msg);
                }
                  
                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}' );
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}
{{--/ sweetalert2 --}}


  $(document).ready(function(){
  // does current browser support PJAX
    if ($.support.pjax) {
      $.pjax.defaults.timeout = 2000; // time in milliseconds
    }

  });

  function order_print(){
    $('.not-print').hide();
    window.print();
    $('.not-print').show();
  }
</script>

@endpush
