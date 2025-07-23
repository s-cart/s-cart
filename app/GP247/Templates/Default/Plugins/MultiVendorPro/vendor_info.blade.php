@php
    $bannerStore = $modelBanner->start()->setType('banner-store')->setLimit(1)->setStore($storeId)->getData();
@endphp

@if ($bannerStore->count())
<div class="banner-ads-top mb-30"><a target="{{ $bannerStore[0]->target }}" href="{{ gp247_route_front('front.banner.click',['id' => $bannerStore[0]->id]) }}"><img src="{{ gp247_file($bannerStore[0]->image) }}" alt="image"></a></div>
@endif


{{-- Quikc order --}}
@if (gp247_config_global('MultiVendorPro_quick_order') && gp247_config_global('MultiVendorPro'))
<div id="quick-order">
    <a href="{{ gp247_route_front('MultiVendorPro.quick_order', ['code' => $storeCode ?? '']) }}">{{ gp247_language_render('multi_vendor.quick_order') }}</a>
</div>
<style>
    #quick-order {
    font-size: 15px;
    position: fixed;
    right: 10px;
    bottom: 30%;
    border-radius: 5px 0;
    font-weight: 600;
    text-align: center;
    margin: 0 auto;
    padding: 10px;
    border: 1px solid #a7a6a6;
    box-shadow: -2px 3px 6px #7a7878;
    cursor: pointer;
    }
    #quick-order:hover {
        background: #f5eaea;
        margin-bottom: 2px;
    }
    #quick-order a {
        color:rgb(27, 27, 83);
    }
    #quick-order a:hover {
        color:rgb(255, 94, 0);
    }
</style>
@endif
{{--// Quikc order --}}