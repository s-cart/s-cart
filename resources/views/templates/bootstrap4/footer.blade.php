<!--Footer-->

<!--Module top footer -->
@isset ($blocksContent['footer'])
@foreach ( $blocksContent['footer']  as $layout)
  @php
    $arrPage = explode(',', $layout->page)
  @endphp
  @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
    @if ($layout->type =='html')
      {!! $layout->text !!}
    @elseif($layout->type =='view')
      @if (view()->exists('blockView.'.$layout->text))
       @include('blockView.'.$layout->text)
      @endif
    @endif
  @endif
@endforeach
@endisset
<!--//Module top footer -->

<!--footer start-->

<footer class="pt-11 bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-3">
        <a class="footer-logo text-white h2 mb-0" href="{{ route('home') }}">
          <img style="max-width: 150px;" src="{{ asset(sc_store('logo')) }}">
        </a>
        <p class="my-3 text-muted">{{ sc_store('title') }}</p>
        <ul class="list-inline mb-0">
          <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-facebook"></i></a>
          </li>
          <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-dribbble"></i></a>
          </li>
          <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-instagram"></i></a>
          </li>
          <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-twitter"></i></a>
          </li>
          <li class="list-inline-item"><a class="text-light ic-2x" href="#"><i class="la la-linkedin"></i></a>
          </li>
        </ul>
      </div>
      <div class="col-12 col-lg-6 mt-6 mt-lg-0">
        <div class="row">
          <div class="col-12 col-sm-4 navbar-dark">
            <h6 class="text-primary mb-1">
              — {{ trans('front.my_account') }}
            </h6>
            <ul class="navbar-nav list-unstyled mb-0">
              @if(!empty($layoutsUrl['footer']))
                @foreach($layoutsUrl['footer'] as $url)
                  <li class="mb-3 nav-item">
                    <a class="nav-link"
                      {{ ($url->target =='_blank')?'target=_blank':'' }}
                      href="{{ sc_url_render($url->url) }}">
                      {{ sc_language_render($url->name) }}
                    </a>
                  </li>
                @endforeach
              @endif
            </ul>
          </div>

    <div class="col-12 col-sm-8 mt-6 mt-sm-0 navbar-dark"">
      <div class=" mb-4">
            <h6 class="text-primary mb-1">
              — Newsletter
            </h6>
          </div>
          <div class="subscribe-form">
            <form id="mc-form" action="{{ route('subscribe') }}" method="post"
              class="searchform row align-items-center no-gutters mb-3">
              @csrf
              <div class="col">
                <input type="email" name="subscribe_email" class="email form-control input-2 bg-white" id="mc-email"
                  required="required" placeholder="{{ trans('front.subscribe.subscribe_email') }}">
              </div>
              <div class="col-auto">
                <input class="btn btn-primary overflow-auto" name="subscribe" value="Subscribe" type="submit">
              </div>
            </form>
            <p class="text-muted mt-2">{{ trans('front.subscribe.subscribe_des') }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-3 mt-6 mt-lg-0">
      <div class="d-flex mb-3">
        <div class="mr-2"> <i class="las la-map ic-2x text-primary"></i>
        </div>
        <div>
          <h6 class="mb-1 text-light">{{ trans('front.about') }}</h6>
          <p class="mb-0 text-muted">{{ trans('front.shop_info.address') }}:
            {{ sc_store('address') }}</p>
        </div>
      </div>
      <div class="d-flex mb-3">
        <div class="mr-2"> <i class="las la-envelope ic-2x text-primary"></i>
        </div>
        <div>
          <h6 class="mb-1 text-light">Email Us</h6>
          <a class="text-muted" href="mailto:themeht23@gmail.com">
            {{ trans('front.shop_info.email') }}: {{ sc_store('email') }}</a>
        </div>
      </div>
      <div class="d-flex mb-3">
        <div class="mr-2"> <i class="las la-mobile ic-2x text-primary"></i>
        </div>
        <div>
          <h6 class="mb-1 text-light">Phone Number</h6>
          <a class="text-muted"
            href="tel:+{{ trans('front.shop_info.hotline') }}">{{ trans('front.shop_info.hotline') }}:
            {{ sc_store('long_phone') }}</a>
        </div>
      </div>
      <div class="d-flex">
        <div class="mr-2"> <i class="las la-clock ic-2x text-primary"></i>
        </div>
        <div>
          <h6 class="mb-1 text-light">Working Hours</h6>
          <span class="text-muted">Mon - Fri: 10AM - 7PM</span>
        </div>
      </div>
    </div>
  </div>
  <hr class="my-4">
  <div class="row text-muted align-items-center pb-4">
    <div class="col-md-7">Copyright ©{{ date('Y') }} All rights reserved | Power by <i
        class="lar la-heart text-primary heartBeat2"></i>
      <u><a class="text-primary" href="#">Shops25</a></u>
    </div>
    <div class="col-md-5 text-md-right mt-3 mt-md-0">
      <ul class="list-inline mb-0">
        <li class="list-inline-item">
          <a href="#">
            <img class="img-fluid" src="assets/images/pay-icon/01.png" alt="">
          </a>
        </li>
        <li class="list-inline-item">
          <a href="#">
            <img class="img-fluid" src="assets/images/pay-icon/02.png" alt="">
          </a>
        </li>
        <li class="list-inline-item">
          <a href="#">
            <img class="img-fluid" src="assets/images/pay-icon/03.png" alt="">
          </a>
        </li>
        <li class="list-inline-item">
          <a href="#">
            <img class="img-fluid" src="assets/images/pay-icon/04.png" alt="">
          </a>
        </li>
      </ul>
    </div>
  </div>
  </div>
</footer>

<!--footer end-->

</div>

<!-- page wrapper end -->

<!-- Cart Modal -->
<div class="modal fade cart-modal" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Your Cart (2)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
            aria-hidden="true">&times;</span>
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
                <img class="img-fluid" src="assets/images/product/01.jpg" alt="...">
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
                <img class="img-fluid" src="assets/images/product/13.jpg" alt="...">
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
        <div class="d-flex justify-content-between align-items-center mb-8"> <span class="text-muted">Subtotal:</span>
          <span class="text-dark">$52.00</span>
        </div> <a href="product-cart.html" class="btn btn-primary btn-animated mr-2"><i
            class="las la-cart-plus mr-1"></i>View Cart</a>
        <a href="product-checkout.html" class="btn btn-dark"><i class="las la-money-check mr-1"></i>Continue To
          Checkout</a>
      </div>
    </div>
  </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade view-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0 pb-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
            aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-lg-5 col-12">
            <img class="img-fluid rounded" src="assets/images/product/large/01.jpg" alt="" />
          </div>
          <div class="col-lg-7 col-12 mt-5 mt-lg-0">
            <div class="product-details">
              <h3 class="mb-0">Women Sweater</h3>
              <div class="star-rating mb-4"><i class="las la-star"></i><i class="las la-star"></i><i
                  class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i>
              </div> <span class="product-price h4">$25.00 <del class="text-muted h6">$35.00</del></span>
              <ul class="list-unstyled my-4">
                <li class="mb-2">Availibility: <span class="text-muted"> In Stock</span>
                </li>
                <li>Categories :<span class="text-muted"> Women's</span>
                </li>
              </ul>
              <p class="mb-4">Nulla eget sem vitae eros pharetra viverra Nam vitae luctus ligula suscipit risus nec
                eleifend Pellentesque eu quam sem, ac malesuada</p>
              <div class="d-sm-flex align-items-center mb-5">
                <div class="d-flex align-items-center mr-sm-4">
                  <button class="btn-product btn-product-up"> <i class="las la-minus"></i>
                  </button>
                  <input class="form-product" type="number" name="form-product" value="1">
                  <button class="btn-product btn-product-down"> <i class="las la-plus"></i>
                  </button>
                </div>
                <select class="custom-select mt-3 mt-sm-0" id="inputGroupSelect01">
                  <option selected>Size</option>
                  <option value="1">XS</option>
                  <option value="2">S</option>
                  <option value="3">M</option>
                  <option value="3">L</option>
                  <option value="3">XL</option>
                  <option value="3">XXL</option>
                </select>
                <div class="d-flex text-center ml-sm-4 mt-3 mt-sm-0">
                  <div class="form-check pl-0 mr-3">
                    <input type="radio" class="form-check-input" id="color-filter01" name="Radios">
                    <label class="form-check-label" for="color-filter01" data-bg-color="#3cb371"></label>
                  </div>
                  <div class="form-check pl-0 mr-3">
                    <input type="radio" class="form-check-input" id="color-filter02" name="Radios" checked>
                    <label class="form-check-label" for="color-filter02" data-bg-color="#4876ff"></label>
                  </div>
                  <div class="form-check pl-0 mr-3">
                    <input type="radio" class="form-check-input" id="color-filter03" name="Radios">
                    <label class="form-check-label" for="color-filter03" data-bg-color="#0a1b2b"></label>
                  </div>
                  <div class="form-check pl-0">
                    <input type="radio" class="form-check-input" id="color-filter04" name="Radios">
                    <label class="form-check-label" for="color-filter04" data-bg-color="#f94f15"></label>
                  </div>
                </div>
              </div>
              <div class="d-sm-flex align-items-center mt-5">
                <button class="btn btn-primary btn-animated mr-sm-4 mb-3 mb-sm-0"><i
                    class="las la-cart-plus mr-1"></i>Add To Cart</button>
                <a class="btn btn-animated btn-dark" href="#"> <i class="lar la-heart mr-1"></i>Add To Wishlist</a>
              </div>
              <div class="d-sm-flex align-items-center border-top pt-4 mt-5">
                <h6 class="mb-sm-0 mr-sm-4">Share It:</h6>
                <ul class="list-inline">
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-facebook"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-dribbble"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-instagram"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-twitter"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-linkedin"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Subscribe Modal -->
<div class="modal fade" id="mailchimpModal-disabled" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" data-bg-img="assets/images/bg/08.png">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
            aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="mb-4">
          <h6 class="text-primary mb-1">
            — Newsletter
          </h6>
          <h2 class="mb-0">Subscribe get notified!</h2>
        </div>
        <div class="subscribe-form">
          <form id="mc-form1" class="row align-items-center no-gutters mb-3">
            <div class="col">
              <input value="" name="EMAIL" class="email form-control input-2 bg-white" id="mc-email1"
                placeholder="Email Address" required="" type="email">
            </div>
            <div class="col-auto">
              <input class="btn btn-primary overflow-auto" name="subscribe" value="Subscribe" type="submit">
            </div>
          </form> <small>Get started for 1 Month free trial No Purchace required.</small>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Footer-->

<!-- page wrapper end -->

<!-- Cart Modal -->
<div class="modal fade cart-modal" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Your Cart (2)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
            aria-hidden="true">&times;</span>
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
                <img class="img-fluid" src="assets/images/product/01.jpg" alt="...">
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
                <img class="img-fluid" src="assets/images/product/13.jpg" alt="...">
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
        <div class="d-flex justify-content-between align-items-center mb-8"> <span class="text-muted">Subtotal:</span>
          <span class="text-dark">$52.00</span>
        </div> <a href="product-cart.html" class="btn btn-primary btn-animated mr-2"><i
            class="las la-cart-plus mr-1"></i>View Cart</a>
        <a href="product-checkout.html" class="btn btn-dark"><i class="las la-money-check mr-1"></i>Continue To
          Checkout</a>
      </div>
    </div>
  </div>
</div>

<!-- Quick View Modal -->
<div class="modal fade view-modal" id="quick-view" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0 pb-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
            aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
          <div class="col-lg-5 col-12">
            <img class="img-fluid rounded" src="assets/images/product/large/01.jpg" alt="" />
          </div>
          <div class="col-lg-7 col-12 mt-5 mt-lg-0">
            <div class="product-details">
              <h3 class="mb-0">Women Sweater</h3>
              <div class="star-rating mb-4"><i class="las la-star"></i><i class="las la-star"></i><i
                  class="las la-star"></i><i class="las la-star"></i><i class="las la-star"></i>
              </div> <span class="product-price h4">$25.00 <del class="text-muted h6">$35.00</del></span>
              <ul class="list-unstyled my-4">
                <li class="mb-2">Availibility: <span class="text-muted"> In Stock</span>
                </li>
                <li>Categories :<span class="text-muted"> Women's</span>
                </li>
              </ul>
              <p class="mb-4">Nulla eget sem vitae eros pharetra viverra Nam vitae luctus ligula suscipit risus nec
                eleifend Pellentesque eu quam sem, ac malesuada</p>
              <div class="d-sm-flex align-items-center mb-5">
                <div class="d-flex align-items-center mr-sm-4">
                  <button class="btn-product btn-product-up"> <i class="las la-minus"></i>
                  </button>
                  <input class="form-product" type="number" name="form-product" value="1">
                  <button class="btn-product btn-product-down"> <i class="las la-plus"></i>
                  </button>
                </div>
                <select class="custom-select mt-3 mt-sm-0" id="inputGroupSelect01">
                  <option selected>Size</option>
                  <option value="1">XS</option>
                  <option value="2">S</option>
                  <option value="3">M</option>
                  <option value="3">L</option>
                  <option value="3">XL</option>
                  <option value="3">XXL</option>
                </select>
                <div class="d-flex text-center ml-sm-4 mt-3 mt-sm-0">
                  <div class="form-check pl-0 mr-3">
                    <input type="radio" class="form-check-input" id="color-filter01" name="Radios">
                    <label class="form-check-label" for="color-filter01" data-bg-color="#3cb371"></label>
                  </div>
                  <div class="form-check pl-0 mr-3">
                    <input type="radio" class="form-check-input" id="color-filter02" name="Radios" checked>
                    <label class="form-check-label" for="color-filter02" data-bg-color="#4876ff"></label>
                  </div>
                  <div class="form-check pl-0 mr-3">
                    <input type="radio" class="form-check-input" id="color-filter03" name="Radios">
                    <label class="form-check-label" for="color-filter03" data-bg-color="#0a1b2b"></label>
                  </div>
                  <div class="form-check pl-0">
                    <input type="radio" class="form-check-input" id="color-filter04" name="Radios">
                    <label class="form-check-label" for="color-filter04" data-bg-color="#f94f15"></label>
                  </div>
                </div>
              </div>
              <div class="d-sm-flex align-items-center mt-5">
                <button class="btn btn-primary btn-animated mr-sm-4 mb-3 mb-sm-0"><i
                    class="las la-cart-plus mr-1"></i>Add To Cart</button>
                <a class="btn btn-animated btn-dark" href="#"> <i class="lar la-heart mr-1"></i>Add To Wishlist</a>
              </div>
              <div class="d-sm-flex align-items-center border-top pt-4 mt-5">
                <h6 class="mb-sm-0 mr-sm-4">Share It:</h6>
                <ul class="list-inline">
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-facebook"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-dribbble"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-instagram"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-twitter"></i></a>
                  </li>
                  <li class="list-inline-item"><a class="bg-white shadow-sm rounded p-2" href="#"><i
                        class="la la-linkedin"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Subscribe Modal -->
<div class="modal fade" id="mailchimpModal-disabled" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" data-bg-img="assets/images/bg/08.png">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
            aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="mb-4">
          <h6 class="text-primary mb-1">
            — Newsletter
          </h6>
          <h2 class="mb-0">Subscribe get notified!</h2>
        </div>
        <div class="subscribe-form">
          <form id="mc-form1" class="row align-items-center no-gutters mb-3">
            <div class="col">
              <input value="" name="EMAIL" class="email form-control input-2 bg-white" id="mc-email1"
                placeholder="Email Address" required="" type="email">
            </div>
            <div class="col-auto">
              <input class="btn btn-primary overflow-auto" name="subscribe" value="Subscribe" type="submit">
            </div>
          </form> <small>Get started for 1 Month free trial No Purchace required.</small>
        </div>
      </div>
    </div>
  </div>
</div>

<!--back-to-top start-->

<div class="scroll-top"><a class="smoothscroll" href="#top"><i class="las la-angle-up"></i></a></div>

<!--back-to-top end-->

<!--back-to-top start-->

<div class="scroll-top"><a class="smoothscroll" href="#top"><i class="las la-angle-up"></i></a></div>

<!--back-to-top end-->
