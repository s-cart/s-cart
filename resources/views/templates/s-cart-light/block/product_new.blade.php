@php
$productsNew = $modelProduct->start()->getProductLatest()->setlimit(sc_config('product_top'))->getData();
@endphp

@if ($productsNew)
      <!-- New Products-->
  <section class="section section-xxl bg-default">
    <div class="container">

        <h2 class="wow fadeScale">{{ sc_language_render('front.products_new') }}</h2>

        <div class="row row-30 row-lg-50">
        @foreach ($productsNew as $key => $productNew)
        <div class="col-sm-6 col-md-4 col-lg-3">
            {{-- Render product single --}}
            @include($sc_templatePath.'.common.product_single', ['product' => $productNew])
            {{-- //Render product single --}}
        </div>
        @endforeach
        </div>
    </div>
    </section>
@endif