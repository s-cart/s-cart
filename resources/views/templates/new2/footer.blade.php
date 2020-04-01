<footer>
    <div class="subscribe">
        <div class="container-sm container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-5 subscribe-title">
                    <i class="far fa-paper-plane"></i>
                    <div>
                        <h4>{{ trans('front.subscribe.title') }}</h4>
                        <p>{{ trans('front.subscribe.subscribe_des') }}</p>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-7 subscribe-form">
                    <form action="{{ route('subscribe') }}" method="post">
                        @csrf
                        <input class="form-control" type="email" name="subscribe_email" required="required"
                            placeholder="{{ trans('front.subscribe.subscribe_email') }}" aria-label="{{ trans('front.subscribe.subscribe_email') }}">
                        <button class="btn" type="submit">{{ trans('front.subscribe.title') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-top">
        <div class="container-sm container">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-6 logo">
                    <a href="{{ route('home') }}">
                        <img src="{{  asset(sc_store('logo')) }}" alt="{{ sc_store('title') }}">
                    </a>
                    <p>{{ sc_store('title') }}</p>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="footer-title">
                        {{ trans('front.my_account') }}
                    </div>
                    <ul>
                        @if (!empty($layoutsUrl['footer']))
                        @foreach ($layoutsUrl['footer'] as $url)
                        <li>
                            <a {{ ($url->target =='_blank')?'target=_blank':''  }}
                                href="{{ sc_url_render($url->url) }}">{{ sc_language_render($url->name) }}</a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="footer-title">
                        {{ trans('front.about') }}
                    </div>
                    <ul>
                        <li>
                            <a href="">{{ trans('front.shop_info.address') }}: {{ sc_store('address') }}</a>
                        </li>
                        <li>
                            <a href="">{{ trans('front.shop_info.hotline') }}: {{ sc_store('long_phone') }}</a>
                        </li>
                        <li>
                            <a href="">{{ trans('front.shop_info.email') }}: {{ sc_store('email') }}</a>
                        </li>
                        <li>
                            <ul class="social-network">
                                <li>
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-google-plus-g"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container-sm container">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-8">Copyright © {{date('Y')}} <a
                        href="{{ route('home') }}">{{ sc_store('title') }} </a> Inc. All rights reserved.</div>
                <div class="col-12 col-sm-4 col-md-4">Power by <a
                        href="{{ config('scart.homepage') }}">{{ config('scart.name') }}
                        {{ config('scart.sub_version') }}</a>. Hosted by <a target="_blank"
                        href="https://giaiphap247.com">GiaiPhap247</a></div>
            </div>
        </div>
    </div>
</footer>
