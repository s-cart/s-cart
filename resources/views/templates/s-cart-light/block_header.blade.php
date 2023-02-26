      <!-- Page Header-->
      <header class="section page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="100px" data-xl-stick-up-offset="100px" data-xxl-stick-up-offset="100px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand">
                    <!--Brand--><a class="brand" href="{{ sc_route('home') }}"><img class="brand-logo-dark" src="{{ sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="" width="105" height="44"/>
                      <img class="brand-logo-light" src="{{ sc_file(sc_store('logo', ($storeId ?? null))) }}" alt="" width="106" height="44"/></a>
                  </div>
                </div>
                <div class="rd-navbar-nav-wrap">
                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                    @if (!empty(sc_link_collection()['menu']))
                    @foreach (sc_link_collection()['menu'] as $url)
                      @if ($url['type'] != 'collection')
                        <li class="rd-nav-item">
                          <a class="rd-nav-link" {{ ($url['data']['target'] =='_blank')?'target=_blank':''  }}
                              href="{{ sc_url_render($url['data']['url']) }}">{{ sc_language_render($url['data']['name']) }}</a>
                        </li>
                      @else
                        @if (count($url['childs']))
                        <li class="rd-nav-item"><a class="rd-nav-link" href="#"><i class="fa fa-lock"></i> {{ $url['data']['name'] }}</a>
                          <ul class="rd-menu rd-navbar-dropdown">
                              @foreach ($url['childs'] as $item)
                              <li class="rd-dropdown-item">
                                <a class="rd-nav-link" {{ ($item['data']['target'] =='_blank')?'target=_blank':''  }}
                                  href="{{ sc_url_render($item['data']['url']) }}">{{ sc_language_render($item['data']['name']) }}</a>
                              </li>
                              @endforeach
                          </ul>
                      </li>
                        @endif
                      @endif

                    @endforeach
                    @endif

                    @if (sc_config('link_account', null, 1) && config('s-cart.ecommerce_mode', 1))
                    @guest
                    <li class="rd-nav-item"><a class="rd-nav-link" href="#"><i class="fa fa-lock"></i> {{ sc_language_render('front.account') }}</a>
                        <ul class="rd-menu rd-navbar-dropdown">
                            <li class="rd-dropdown-item">
                                <a class="rd-dropdown-link" href="{{ sc_route('login') }}"><i class="fa fa-user"></i> {{ sc_language_render('front.login') }}</a>
                            </li>

                            <li class="rd-dropdown-item">
                                <a class="rd-dropdown-link" href="{{ sc_route('wishlist') }}"><i class="fas fa-heart"></i> {{ sc_language_render('front.wishlist') }} 
                                    <span class="count sc-wishlist"
                                    id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span>
                                </a>
                            </li>
                            <li class="rd-dropdown-item">
                                <a class="rd-dropdown-link" href="{{ sc_route('compare') }}"><i class="fa fa-exchange"></i> {{ sc_language_render('front.compare') }} 
                                    <span class="count sc-compare"
                                    id="shopping-compare">{{ Cart::instance('compare')->count() }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    @else
                    <li class="rd-nav-item"><a class="rd-nav-link" href="#"><i class="fa fa-lock"></i> {{ sc_language_render('customer.my_profile') }}</a>
                        <ul class="rd-menu rd-navbar-dropdown">
                            <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="{{ sc_route('customer.index') }}"><i class="fa fa-user"></i> {{ sc_language_render('front.my_profile') }}</a></li>
                            <li class="rd-dropdown-item"><a class="rd-dropdown-link" href="{{ sc_route('logout') }}" rel="nofollow" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> {{ sc_language_render('front.logout') }}</a></li>
                            <li class="rd-dropdown-item">
                                <a class="rd-dropdown-link" href="{{ sc_route('wishlist') }}"><i class="fas fa-heart"></i> {{ sc_language_render('front.wishlist') }} 
                                    <span class="count sc-wishlist"
                                    id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span>
                                </a>
                            </li>
                            <li class="rd-dropdown-item">
                                <a class="rd-dropdown-link" href="{{ sc_route('compare') }}"><i class="fa fa-exchange"></i> {{ sc_language_render('front.compare') }} 
                                    <span class="count sc-compare"
                                    id="shopping-compare">{{ Cart::instance('compare')->count() }}</span>
                                </a>
                            </li>
                            <form id="logout-form" action="{{ sc_route('logout') }}" method="POST" style="display: none;">
                              @csrf
                            </form>
                        </ul>
                    </li>
                    @endguest
                    @endif

                    @if (sc_config('link_language', null, 1))
                    @if (count($sc_languages)>1)
                    <li class="rd-nav-item">
                        <a class="rd-nav-link" href="#">
                            <img src="{{ sc_file($sc_languages[app()->getLocale()]['icon']) }}" style="height: 25px;"> <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="rd-menu rd-navbar-dropdown">
                            @foreach ($sc_languages as $key => $language)
                            <li class="rd-dropdown-item">
                                <a class="rd-dropdown-link" href="{{ sc_route('locale', ['code' => $key]) }}">
                                    <img src="{{ sc_file($language['icon']) }}" style="height: 25px;"> {{ $language['name'] }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endif

                    @if (sc_config('link_currency', null, 1) && config('s-cart.ecommerce_mode', 1))
                    @if (count($sc_currencies)>1)
                    <li class="rd-nav-item">
                        <a class="rd-nav-link" href="#">
                            {{ sc_currency_info()['name'] }} <i class="fas fa-caret-down"></i>
                        </a>
                        <ul class="rd-menu rd-navbar-dropdown">
                            @foreach ($sc_currencies as $key => $currency)
                            <li class="rd-dropdown-item" {{ ($currency->code ==  sc_currency_info()['code']) ? 'disabled': '' }}>
                                <a class="rd-dropdown-link" href="{{ sc_route('currency', ['code' => $currency->code]) }}">
                                    {{ $currency->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endif

                  </ul>
                </div>

                <div class="rd-navbar-main-element">
                  <!-- RD Navbar Search-->
                  <div class="rd-navbar-search rd-navbar-search-2">
                    <button class="rd-navbar-search-toggle rd-navbar-fixed-element-3" data-rd-navbar-toggle=".rd-navbar-search"><span></span></button>
                    <form class="rd-search" action="{{ sc_route('search') }}"  method="GET">
                      <div class="form-wrap">
                        <input class="rd-navbar-search-form-input form-input"  type="text" name="keyword"  placeholder="{{ sc_language_render('search.placeholder') }}"/>
                        <button class="rd-search-form-submit" type="submit"></button>
                      </div>
                    </form>
                  </div>
                  @if (sc_config('link_cart', null, 1) && config('s-cart.ecommerce_mode', 1))
                  <!-- RD Navbar Basket-->
                  <div class="rd-navbar-basket-wrap">
                    <a href="{{ sc_route('cart') }}">
                    <button class="rd-navbar-basket fl-bigmug-line-shopping202">
                      <span class="count sc-cart" id="shopping-cart">{{ Cart::instance('default')->count() }}</span>
                    </button>
                    </a>
                  </div>
                  <a title="{{ sc_language_render('cart.page_title') }}" style="margin-top:10px;" class="rd-navbar-basket rd-navbar-basket-mobile fl-bigmug-line-shopping202 rd-navbar-fixed-element-2" href="{{ sc_route('cart') }}">
                    <span class="count sc-cart">{{ Cart::instance('default')->count() }}</span>
                 </a>
                @endif
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
