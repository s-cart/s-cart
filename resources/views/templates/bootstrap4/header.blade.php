<!--header start-->

<header class="site-header">
  <div class="header-top bg-dark py-1">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-12 d-flex align-items-center justify-content-between text-white">
          <div class="d-none d-md-flex align-items-center"> 
            <small class="mr-3">
              <i class="las la-store text-primary mr-1 align-middle"></i> 
              Welcome to Our store Ekocart
            </small>  
            <small>
              <i class="las la-truck text-primary mr-1 align-middle"></i> 
              Free shipping worldwide
            </small> 
          </div>
          <div class="d-flex align-items-center">
            <div class="language-selection mr-2">
              <div class="dropdown">
                @if ($languages->isNotEmpty())
                  <button class="btn btn-sm text-white dropdown-toggle" data-toggle="dropdown">{{$languages->first()->name}}</button>
                  <div class="dropdown-menu">
                    @foreach ($languages as $key => $language)
                      <a href="{{ url('locale/'.$key) }}" class="dropdown-item">{{$language->name}}</a>
                    @endforeach
                  </div>
                @endif
              </div>
            </div>
            <div class="language-selection mr-2">
              <div class="dropdown">
                @if ($currencies->isNotEmpty())
                  <button class="btn btn-sm text-white dropdown-toggle" data-toggle="dropdown">{{$currencies->first()->name}}</button>
                  <div class="dropdown-menu">
                    @foreach ($currencies as $key => $currency)
                      <a href="{{ url('currency/'.$currency->code) }}" class="dropdown-item">{{$currency->name}}</a>
                    @endforeach
                  </div>
                @endif
              </div>
            </div>
            <div class="social-icons">
              <ul class="list-inline mb-0">
                <li class="list-inline-item"><a class="text-muted" href="#"><i class="lab la-facebook-f"></i></a>
                </li>
                <li class="list-inline-item"><a class="text-muted" href="#"><i class="lab la-twitter"></i></a>
                </li>
                <li class="list-inline-item"><a class="text-muted" href="#"><i class="lab la-linkedin-in"></i></a>
                </li>
                <li class="list-inline-item"><a class="text-muted" href="#"><i class="lab la-instagram"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="py-md-3 py-2">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 d-none d-md-flex align-items-center">
          <a class="navbar-brand logo d-none d-lg-block" href="index.html">
            <img class="img-fluid" src="templates/bootstrap4/images/logo.png" alt="">
          </a>
          <div class="media ml-lg-11"> <i class="las la-mobile-alt ic-2x bg-white rounded p-2 shadow-sm mr-2 text-primary"></i>
            <div class="media-body"> <span class="mb-0 d-block">Call Us</span>
              <a class="text-muted" href="{{"tel:+".sc_store('phone')}}">+{{sc_store('phone')}}</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="right-nav align-items-center d-flex justify-content-end">
            <form class="form-inline border rounded w-100">
              {{--<select class="custom-select border-0 rounded-0 bg-light form-control d-none d-lg-inline">
                <option selected>All Categories</option>
                <option value="1">Men</option>
                <option value="2">Women</option>
                <option value="3">Kids</option>
              </select>--}}
              <form id="searchbox" method="get" action="{{ route('search') }}" >
                <input class="form-control border-0 border-left col"
                  action="{{ route('search') }}"
                  name="keyword"
                  method="get" 
                  type="search" 
                  placeholder="{{ trans('front.search_form.keyword') }}..."
                  aria-label="Search"
                >
              </form>

              <button class="btn btn-primary text-white col-auto" type="submit"><i class="las la-search"></i>
              </button>
            </form>
          </div>
        </div>
        <!--menu end-->
      </div>
    </div>
  </div>
  <div id="header-wrap" class="shadow-sm">
    <div class="container">
      <div class="row">
        <!--menu start-->
        <div class="col">
          <nav class="navbar navbar-expand-lg navbar-light position-static">
            <a class="navbar-brand logo d-lg-none" href="index.html">
              <img class="img-fluid" src="templates/bootstrap4/images/logo.png" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item active"> 
                  <a class="nav-link" href="{{route('home')}}">
                    {{trans('front.home')}}
                  </a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="true">{{trans('front.shop')}}</a>
                  <ul class="dropdown-menu">
                    <li><a href="{{ route('product.all') }}">{{ trans('front.all_product') }}</a></li>
                    <li><a href="{{ route('compare') }}">{{ trans('front.compare') }}</a></li>
                    <li><a href="{{ route('cart') }}">{{ trans('front.cart_title') }}</a></li>
                    <li><a href="{{ route('category.all') }}">{{ trans('front.categories') }}</a></li>
                    <li><a href="{{ route('brand.all') }}">{{ trans('front.brands') }}</a></li>
                    <li><a href="{{ route('supplier.all') }}">{{ trans('front.suppliers') }}</a></li>
                  </ul>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link" href="{{route('news')}}">
                    {{trans('front.blog')}}
                  </a>
                </li>
                @if (!empty(sc_config('Content')))
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="true">{{trans('front.cms_category')}}</a>
                    <ul class="dropdown-menu">
                      @php
                          $nameSpace = sc_get_plugin_namespace('Cms','Content').'\Models\CmsCategory';
                          $cmsCategories = (new $nameSpace)->getCategoryRoot()->getData();
                        @endphp
                        @foreach ($cmsCategories as $cmsCategory)
                          <li><a href="{{ $cmsCategory->getUrl() }}">{{ sc_language_render($cmsCategory->title) }}</a></li>
                        @endforeach
                    </ul>
                  </li>
                @endif
                @if (!empty($layoutsUrl['menu']))
                  @foreach ($layoutsUrl['menu'] as $url)
                  <li class="nav-item">
                      <a class="nav-link" {{ ($url->target =='_blank')?'target=_blank':''  }}
                          href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a>
                  </li>
                  @endforeach
                @endif
              </ul>
            </div>
            <div class="right-nav align-items-center d-flex justify-content-end"> 
              <div>
                <a class="mr-1 mr-sm-3" href="#">
                  <span class="bg-white px-2 py-1 shadow-sm rounded">
                    <i class="las la-user-alt"></i>
                  </span>
                </a>
              </div>
              
              <div>
                <a class="mr-3 d-none d-sm-inline" href="{{ route('wishlist') }}" id="shopping-wishlist" data-toggle="modal" data-target="#shoppingWishlist"> 
                  <span class="bg-white px-2 py-1 shadow-sm rounded" data-cart-items="{{Cart::instance('wishlist')->count()}}">
                    <i class="lar la-heart"></i>
                  </span>
                </a>
              </div>

              <div>
                <a class="d-flex align-items-center" href="#" id="shopping-cart" data-toggle="modal" data-target="#shoppingCart"> 
                  <span class="bg-white px-2 py-1 shadow-sm rounded" data-cart-items="{{Cart::instance('default')->count()}}">
                  <i class="las la-cart-plus"></i>
                </span>
                  <div class="ml-4 d-none d-md-block"> 
                    <small class="d-block text-muted">My Cart</small>
                    <span class="text-dark">{{Cart::instance('default')->count()}} Items</span>
                  </div>
                </a>
              </div>
              {{--<a href="{{ route('wishlist') }}">
                <i class="fas fa-heart"></i> 
                <span class="title">{{ trans('front.wishlist') }}</span> 
                <span class="count sc-wishlist" id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span>
              </a>
              <a href="{{ route('cart') }}">
                <i class="fa fa-shopping-cart"></i> 
                <span class="title">{{ trans('front.cart_title') }}</span> 
                <span class="count sc-cart" id="shopping-cart">{{ Cart::instance('default')->count() }}</span>
              </a>--}}
            </div>
          </nav>
        </div>
        <!--menu end-->
      </div>
    </div>
  </div>
</header>

<!-- Cart Modal -->
<div class="modal fade cart-modal" id="shoppingCart" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Your Cart (2)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="row align-items-center">
            <div class="col-5 d-flex align-items-center">
              <div class="mr-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="las la-times"></i>
                </button>
              </div>
              <!-- Image -->
              <a href="product-left-image.html">
                <img class="img-fluid" src="templates/bootstrap4/images/product/01.jpg" alt="...">
              </a>
            </div>
            <div class="col-7">
              <!-- Title -->
              <h6><a class="link-title" href="product-left-image.html">Women Lather Jacket</a></h6>
              <div class="product-meta"><span class="mr-2 text-primary">$25.00</span><span class="text-muted">x 1</span>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-5">
        <div>
          <div class="row align-items-center">
            <div class="col-5 d-flex align-items-center">
              <div class="mr-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="las la-times"></i>
                </button>
              </div>
              <!-- Image -->
              <a href="product-left-image.html">
                <img class="img-fluid" src="templates/bootstrap4/images/product/13.jpg" alt="...">
              </a>
            </div>
            <div class="col-7">
              <!-- Title -->
              <h6><a class="link-title" href="product-left-image.html">Men's Brand Tshirts</a></h6>
              <div class="product-meta"><span class="mr-2 text-primary">$27.00</span><span class="text-muted">x 1</span>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-5">
        <div class="d-flex justify-content-between align-items-center mb-8"> <span class="text-muted">Subtotal:</span>  <span class="text-dark">$52.00</span> 
        </div> <a href="product-cart.html" class="btn btn-primary btn-animated mr-2"><i class="las la-cart-plus mr-1"></i>View Cart</a>
        <a href="product-checkout.html" class="btn btn-dark"><i class="las la-money-check mr-1"></i>Continue To Checkout</a>
      </div>
    </div>
  </div>
</div>

<!--header end-->


<!-- Cart Modal -->
<div class="modal fade cart-modal" id="shoppingWishlist" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Your Cart (2)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="row align-items-center">
            <div class="col-5 d-flex align-items-center">
              <div class="mr-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="las la-times"></i>
                </button>
              </div>
              <!-- Image -->
              <a href="product-left-image.html">
                <img class="img-fluid" src="templates/bootstrap4/images/product/01.jpg" alt="...">
              </a>
            </div>
            <div class="col-7">
              <!-- Title -->
              <h6><a class="link-title" href="product-left-image.html">Women Lather Jacket</a></h6>
              <div class="product-meta"><span class="mr-2 text-primary">$25.00</span><span class="text-muted">x 1</span>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-5">
        <div>
          <div class="row align-items-center">
            <div class="col-5 d-flex align-items-center">
              <div class="mr-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="las la-times"></i>
                </button>
              </div>
              <!-- Image -->
              <a href="product-left-image.html">
                <img class="img-fluid" src="templates/bootstrap4/images/product/13.jpg" alt="...">
              </a>
            </div>
            <div class="col-7">
              <!-- Title -->
              <h6><a class="link-title" href="product-left-image.html">Men's Brand Tshirts</a></h6>
              <div class="product-meta"><span class="mr-2 text-primary">$27.00</span><span class="text-muted">x 1</span>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-5">
        <div class="d-flex justify-content-between align-items-center mb-8"> <span class="text-muted">Subtotal:</span>  <span class="text-dark">$52.00</span> 
        </div> <a href="product-cart.html" class="btn btn-primary btn-animated mr-2"><i class="las la-cart-plus mr-1"></i>View Cart</a>
        <a href="product-checkout.html" class="btn btn-dark"><i class="las la-money-check mr-1"></i>Continue To Checkout</a>
      </div>
    </div>
  </div>
</div>

<!--header end-->