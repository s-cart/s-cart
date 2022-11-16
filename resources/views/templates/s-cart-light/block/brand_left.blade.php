@php
$brands = $modelBrand->start()->getData()
@endphp
@if ($brands->count())
<div class="aside-item col-sm-6 col-lg-12">
    <h6 class="aside-title">{{ sc_language_render('front.brands') }}</h6>
    <div class="row row-10 row-lg-20 gutters-10">
        <div class="group-sm group-tags">
            @foreach ($brands as $brand)
            <a class="link-tag" href="{{ $brand->getUrl() }}"> {{ $brand->name }}</a>
            @endforeach
        </div>
    <!--brands_products-->
    </div>
</div>
<!--/brands_products-->
@endif
