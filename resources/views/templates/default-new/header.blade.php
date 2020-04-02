@php
$categories = $modelCategory->start()->getList(['status' => 1]);
$categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
@endphp
<header>
    <div class="header-top">
        <div class="container-sm container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 hidden">
                    <ul class="d-flex flex-row header-top-left">
                        <li>
                            <a href="tel:{{ sc_store('phone') }}"><i class="fa fa-phone"></i>
                                {{ sc_store('phone') }}</a>
                        </li>
                        <li>
                            <a href="mailto:{{ sc_store('email') }}"><i class="fa fa-envelope"></i>
                                {{ sc_store('email') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-sm-12 col-md-6 d-flex flex-row-reverse flex-space-between">
                    <ul class="d-flex flex-row-reverse header-top-right">
                        @if (count($currencies)>1)
                        <li>
                            <a>{{ sc_currency_info()['name'] }} <i class="fas fa-caret-down"></i></a>
                            <div class="header-top-popup-wrap">
                                <ul>
                                    @foreach ($currencies as $key => $currency)
                                    <li>
                                        <a href="{{ url('currency/'.$currency->code) }}">{{ $currency->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                        @if (count($languages)>1)
                        <li>
                            <a><img src="{{ asset($languages[app()->getLocale()]['icon']) }}" alt="lang">
                                {{$languages[app()->getLocale()]['name']}} <i class="fas fa-caret-down"></i></a>
                            <div class="header-top-popup-wrap">
                                <ul>
                                    @foreach ($languages as $key => $language)
                                    <li>
                                        <a href="{{ url('locale/'.$key) }}"><img src="{{ asset($language['icon']) }}"
                                                alt="{{ $language['name'] }}"> {{ $language['name'] }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @endif
                    </ul>
                    <ul class="d-flex flex-row-reverse header-top-right account">
                        <li>
                            <a><i class="fas fa-user"></i> {{ trans('front.account') }} <i
                                    class="fas fa-caret-down"></i></a>
                            <div class="header-top-popup-wrap">
                                <ul>
                                    @guest
                                    <li>
                                        <a href="{{ route('login') }}">{{ trans('front.login') }}</a>
                                    </li>
                                    @else
                                    <li>
                                        <a href="{{ route('member.index') }}">{{ trans('front.account') }}</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ trans('front.logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">@csrf</form>
                                    </li>
                                    @endguest
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle">
        <div class="container-sm container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset(sc_store('logo')) }}" alt="logo_s-cart">
                    </a>
                </div>
                <div class="col-12 col-sm-12 col-md-8 header-middle-menu">
                    <form action="{{ route('search') }}" method="get" class="form-inline form-search">
                        <input class="form-control" type="search" name="keyword"
                            placeholder="{{ trans('front.search_form.keyword') }}..." aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i
                                class="fa fa-search"></i></button>
                    </form>
                    <a href="{{ route('wishlist') }}"><i class="fas fa-heart"></i> <span
                            class="title">{{ trans('front.wishlist') }}</span> <span class="count sc-wishlist"
                            id="shopping-wishlist">{{ Cart::instance('wishlist')->count() }}</span></a>
                    <a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> <span
                            class="title">{{ trans('front.cart_title') }}</span> <span class="count sc-cart"
                            id="shopping-cart">{{ Cart::instance('default')->count() }}</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container-sm container">
            <div class="row">
                <div
                    class="col-6 col-sm-8 col-md-3 clear-padding-right categories @if(Route::currentRouteName() == 'home') {{'active-home'}} @endif">
                    @if ($categoriesTop->count())
                    <div class="btn-categories">
                        <img src="{{asset($templateFile.'/images/catalog.png')}}" alt="">
                        {{ trans('front.categories') }}
                    </div>
                    <ul>
                        <div class="logo-nav-sm">
                            <a class="nav-close" id="close-categories"><i class="fas fa-times"></i></a>
                            <a href="{{ route('home') }}" class="">
                                <img src="{{ asset(sc_store('logo')) }}" alt="logo_s-cart">
                            </a>
                        </div>
                        @foreach ($categoriesTop as $key => $category)
                        @if (!empty($categories[$category->id]))
                        <li>
                            <a href="{{ $category->getUrl() }}">{{ $category->title }}</a>
                            <a class="btn-active"> <i class="fa fa-plus"></i>
                            </a>
                            <ul>
                                @foreach ($categories[$category->id] as $cateChild)
                                <li>
                                    <a href="{{ $cateChild->getUrl() }}">
                                        {{ $cateChild->title }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <li>
                            <a href="{{ $category->getUrl() }}">{{ $category->title }}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="col-6 col-sm-4 col-md-9 d-flex flex-row-reverse">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="navbar-collapse collapse" id="navbarSupportedContent">
                            <div class="logo-nav-sm">
                                <a class="nav-close" id="close-nav"><i class="fas fa-times"></i></a>
                                <a href="{{ route('home') }}" class="">
                                    <img src="{{ asset(sc_store('logo')) }}" alt="logo_s-cart">
                                </a>
                            </div>
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ route('home') }}">{{ trans('front.home') }} <span
                                            class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ trans('front.shop') }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item"
                                            href="{{ route('product.all') }}">{{ trans('front.all_product') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('compare') }}">{{ trans('front.compare') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('cart') }}">{{ trans('front.cart_title') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('category.all') }}">{{ trans('front.categories') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('brand.all') }}">{{ trans('front.brands') }}</a>
                                        <a class="dropdown-item"
                                            href="{{ route('supplier.all') }}">{{ trans('front.suppliers') }}</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('news') }}">{{ trans('front.blog') }}</a>
                                </li>
                                @if (!empty(sc_config('Content')))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ trans('front.cms_category') }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @php
                                        $nameSpace = sc_get_plugin_namespace('Cms','Content').'\Models\CmsCategory';
                                        $cmsCategories = (new $nameSpace)->getCategoryRoot()->getData();
                                        @endphp
                                        @foreach ($cmsCategories as $cmsCategory)
                                        <a class="dropdown-item"
                                            href="{{ $cmsCategory->getUrl() }}">{{ sc_language_render($cmsCategory->title) }}</a>
                                        @endforeach
                                    </div>
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
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
