
@php
// Use GP247 helper
if (function_exists('gp247_product_flash')) {
    $productFlashSale = gp247_product_flash(2);
    $plugin = null;
    if (class_exists('\App\GP247\Plugins\ProductFlashSale\AppConfig')) {
        $plugin = new \App\GP247\Plugins\ProductFlashSale\AppConfig();
    }

} else {
    $productFlashSale = [];
    $plugin = null;
}
@endphp
@if (count($productFlashSale) && $plugin)
<!-- START SECTION SHOP -->
<div class="section bg-default">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="heading_tab_header">
                <div class="heading_s2">
                    <h2 class="wow fadeScale"><a href="{{ route('product_flash_sale.index') }}" class="text_default">{{ gp247_language_render($plugin->appPath.'::lang.front.flash_title') }}</a></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="row row-30 row-lg-50">
                @foreach ($productFlashSale as $product)
                <div class="col-sm-6">

                    <!-- Product-->
                    <div class="deal_wrap">
                        <div class="product_img">
                            <a href="{{ $product->getUrl() }}">
                                <img src="{{ gp247_file($product->getThumb()) }}" alt="el_img1">
                            </a>
                        </div>
                        <div class="deal_content">
                            <div class="product_info">
                                <h5 class="product_title"><a href="{{ $product->getUrl() }}">{{ $product->getName() }}</a></h5>
                                {!! $product->showPrice() !!}
                            </div>
                            <div class="deal_progress">
                                <span class="stock-sold">{{ gp247_language_render($plugin->appPath.'::lang.front.flash_sold') }}: <strong>{{ $product->pf_sold }}</strong></span>
                                <span class="stock-available">{{ gp247_language_render($plugin->appPath.'::lang.front.flash_stock') }}: <strong>{{ $product->pf_stock }}</strong></span>
                                <div class="progress">
                                    @if ($product->pf_stock)
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{ round($product->pf_sold/$product->pf_stock*100) }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ round($product->pf_sold/$product->pf_stock*100) }}%"> {{ round($product->pf_sold/$product->pf_stock*100) }}% </div>
                                    @else
                                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"> N/A </div>
                                    @endif
                                </div>
                            </div>
                            <div class="countdown_time" data-time="{{ $product->promotionPrice->date_end }}"></div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
           
        </div>
    </div>
</div>
</div>
<style>
.deal_wrap {
border: 2px solid #FF324D;
border-radius: 20px;
overflow: hidden;
display: -ms-flexbox;
display: flex;
-ms-flex-align: center;
align-items: center;
margin-bottom: 25px;
}
.deal_wrap .product_img {
max-width: 200px;
width: 100%;
}
.deal_wrap .deal_content {
width: 100%;
padding: 30px 30px 30px 0;
}
.deal_wrap .deal_content .product_info {
padding: 0;
}

.deal_wrap .countdown_box_cus {
float: left;
width: 25%;
padding: 5px;
}
.deal_wrap .countdown_box_cus .countdown-wrap-cus {
background: #dad6d6;
}
.deal_wrap .countdown_box_cus .countdown-cus {
font-size: 24px;
display: block;
}
.deal_wrap .countdown_time .cd_text {
font-size: 13px;
display: block;
}
.deal_wrap .deal_content .deal_progress {
padding-top: 5px;
display: block;
}
.deal_wrap .deal_content .deal_progress .stock-available {
float: right;
}
.deal_wrap .deal_content .deal_progress .progress {
margin-top: 5px;
margin-bottom: 20px;
border-radius: 20px;
}
.deal_progress .progress-bar {
background-color: #FF324D;
text-indent: -99999px;
}

</style>
@endif


@push('scripts')
<!-- END SECTION SHOP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
$('.countdown_time').each(function() {
    var endTime = $(this).data('time');
    $(this).countdown(endTime, function(tm) {
        let html = '<div class="countdown_box_cus"><div class="countdown-wrap-cus"><span class="countdown-cus days">%D </span><span class="cd_text">Days</span></div></div><div class="countdown_box_cus"><div class="countdown-wrap-cus"><span class="countdown-cus hours">%H</span><span class="cd_text">Hours</span></div></div><div class="countdown_box_cus"><div class="countdown-wrap-cus"><span class="countdown-cus minutes">%M</span><span class="cd_text">Minutes</span></div></div><div class="countdown_box_cus"><div class="countdown-wrap-cus"><span class="countdown-cus seconds">%S</span><span class="cd_text">Seconds</span></div></div>';
        $(this).html(tm.strftime(html));
    });
});
</script>
@endpush
