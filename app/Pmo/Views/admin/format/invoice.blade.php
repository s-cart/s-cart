<!-- Font Awesome -->
<link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ sc_file('admin/LTE/dist/css/adminlte.min.css')}}">

<div class="page-content container">
    <div class="page-header text-blue-d2">
      <img src="{{ sc_file(sc_store('logo')) }}" style="max-height:60px;">
        <div class="page-tools">
            <div class="action-buttons">
                <a class="btn bg-white btn-light mx-1px text-95 dont-print" onclick="order_print()" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
                {{-- <a class="btn bg-white btn-light mx-1px text-95 dont-print" href="#" data-title="PDF">
                  <i class="mr-1 text-danger-m1 text-120 w-2 far fa-file-pdf"></i>
                    Export
                </a> --}}
                <a class="btn bg-white btn-light mx-1px text-95 dont-print" href="{{ sc_route_admin('admin_order.invoice', ['order_id' => $id, 'action' => 'invoice_excel']) }}" data-title="PDF">
                  <i class="mr-1 text-primary-m1 text-120 w-2 far fa-file-excel"></i>
                    Export
                </a>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-150">
                            <span class="text-default-d3">{{ sc_store('title') }}</span>
                        </div>
                    </div>
                </div>
                <!-- .row -->

                <hr class="row brc-default-l1 mx-n1 mb-4" />

                <div class="row">
                    <div class="col-sm-6">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">{{ $name }}</span>
                        </div>
                        <div class="text-grey-m2">
                            <div class="my-1">
                              <i class="fas fa-map-marker-alt"></i> {{ $address }}, {{ $country }}
                            </div>
                            <div class="my-1"><i class="fas fa-phone-alt"></i> {{ $phone }}</div>
                            <div class="my-1"><i class="far fa-envelope"></i> {{ $email }}</div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">{{ sc_language_render('order.id') }}:</span> #{{ $id }}</div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">{{ sc_language_render('order.date') }}:</span> {{ sc_datetime_to_date($created_at, 'Y-m-d') }}</div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">{{ sc_language_render('order.currency') }}:</span> {{ $currency }}</div>
                            <div class="my-1"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-90">{{ sc_language_render('order.exchange_rate') }}:</span> {{ $exchange_rate }}</div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <div class="mt-4">
                    <div class="row text-600 text-white bgc-default-tp1 py-25">
                        <div class="d-none d-sm-block col-1">#</div>
                        <div class="col-9 col-sm-5">Description</div>
                        <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                        <div class="d-none d-sm-block col-sm-2">Unit Price</div>
                        <div class="col-2">Amount</div>
                    </div>

                    <div class="text-95 text-secondary-d3">
                        @foreach ($details as $detail)
                        <div class="row mb-2 mb-sm-0 py-25">
                          <div class="d-none d-sm-block col-1">{{ $detail['no'] }}</div>
                          <div class="col-9 col-sm-5">{{ $detail['name'] }}</div>
                          <div class="d-none d-sm-block col-2">{{ $detail['qty'] }}</div>
                          <div class="d-none d-sm-block col-2 text-95 text-right">{{ number_format($detail['price']) }}</div>
                          <div class="col-2 text-secondary-d2 text-right">{{ number_format($detail['total_price']) }}</div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="row border-b-2 brc-default-l2"></div>


                    <div class="row mt-3">
                        <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                            <i>{!! $comment !!}</i>
                        </div>

                        <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.subtotal') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($subtotal, $currency) }}</span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.tax') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($tax, $currency) }}</span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.shipping') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($shipping, $currency) }}</span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.discount') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($discount, $currency) }}</span>
                                </div>
                            </div>
                            <div class="row my-2 high-light">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.total') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($total, $currency) }}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.other_fee') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($other_fee, $currency) }}</span>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.received') }}
                                </div>
                                <div class="col-5 text-right">
                                    <span class="text-120 text-secondary-d1">{{ sc_currency_render_symbol($received, $currency) }}</span>
                                </div>
                            </div>
                            <div class="row my-2 align-items-center bgc-primary-l3 p-2 high-light">
                                <div class="col-7 text-right">
                                    {{ sc_language_render('order.totals.balance') }}
                                </div>
                                <div class="col-5 text-right">
                                  <span class="text-150 text-success-d3 opacity-2">{{ sc_currency_render_symbol($balance, $currency) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ sc_file('admin/LTE/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ sc_file('admin/LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script>
  function order_print(){
    $('.dont-print').hide();
    window.print();
    $('.dont-print').show();
  }
</script>
<style>
  body{
    margin-top:20px;
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}
.high-light {
  background: #eaedef;
    font-weight: bold;
    color: #000;
}
</style>