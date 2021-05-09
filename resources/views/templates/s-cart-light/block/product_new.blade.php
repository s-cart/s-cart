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
            <!-- Product-->
            <article class="product wow fadeInRight">
                <div class="product-body">

                {{-- Product image --}}
                <div class="product-figure">
                    <a href="{{ $productNew->getUrl() }}">
                    <img src="{{ sc_file($productNew->getThumb()) }}" alt="{{ $productNew->name }}"/>
                    </a>
                </div>
                {{--// Product image --}}

                {{-- Product name --}}
                <h5 class="product-title"><a href="{{ $productNew->getUrl() }}">{{ $productNew->name }}</a></h5>
                {{--// Product name --}}

                {{-- Display store - if use MultiVendorPro --}}
                @if (sc_config_global('MultiVendorPro') && config('app.storeId') == SC_ID_ROOT)
                    <div class="store-url"><a href="{{ $productNew->goToStore() }}"><i class="fa fa-shopping-bag" aria-hidden="true"></i> {{ sc_language_render('front.store').' '. $productNew->store_id  }}</a>
                    </div>
                @endif
                {{-- //Display store - if use MultiVendorPro --}}

                {{-- Add to cart --}}
                @if ($productNew->allowSale())
                    <a onClick="addToCartAjax('{{ $productNew->id }}','default','{{ $productNew->store_id }}')" class="button button-secondary button-zakaria add-to-cart-list"><i class="fa fa-cart-plus"></i> {{sc_language_render('action.add_to_cart')}}</a>
                @endif
                {{-- //Add to cart --}}

                {!! $productNew->showPrice() !!}
                </div>
                
                {{-- Product type --}}
                @if ($productNew->price != $productNew->getFinalPrice() && $productNew->kind !=SC_PRODUCT_GROUP)
                <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
                @elseif($productNew->kind == SC_PRODUCT_BUILD)
                <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
                @elseif($productNew->kind == SC_PRODUCT_GROUP)
                <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
                @endif
                {{-- //Product type --}}

                {{-- wishlist, compare --}}
                <div class="product-button-wrap">
                <div class="product-button">
                    <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','wishlist','{{ $productNew->store_id }}')">
                        <i class="fas fa-heart"></i>
                    </a>
                </div>
                <div class="product-button">
                    <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $productNew->id }}','compare','{{ $productNew->store_id }}')">
                        <i class="fa fa-exchange"></i>
                    </a>
                </div>
                {{-- //wishlist, compare --}}

                </div>
            </article>
            </div>
        @endforeach
        </div>
    </div>
    </section>
@endif