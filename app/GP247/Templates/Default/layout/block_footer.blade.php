      <!-- Page Footer-->
      <footer class="section footer-classic">
        <div class="footer-classic-body section-lg bg-brown-2">
          <div class="container">
            <div class="row row-40 row-md-50 justify-content-xl-between">
              <div class="col-sm-6 col-lg-4 col-xl-3 wow fadeInRight">
                <a href="{{ gp247_route_front('front.home') }}">
                    <img class="logo-footer" src="{{  gp247_file(gp247_store_info('logo', ($storeId ?? null))) }}" alt="{{ gp247_store_info('title', ($storeId ?? null)) }}">
                </a>
                <p>{{ gp247_store_info('title', ($storeId ?? null)) }}</p>
                <p> {!! gp247_store_info('time_active', ($storeId ?? null))  !!}</p>
                <div class="footer-classic-social">
                  <div class="group-lg group-middle">
                    <div>
                      <ul class="list-inline list-social list-inline-sm">
                        @if (gp247_config('facebook_url'))
                        <li><a class="icon mdi mdi-facebook" href="{{ gp247_config('facebook_url') }}"></a></li>
                        @endif
                        @if (gp247_config('twitter_url'))
                        <li><a class="icon mdi mdi-twitter" href="{{ gp247_config('twitter_url') }}"></a></li>
                        @endif
                        @if (gp247_config('instagram_url'))
                        <li><a class="icon mdi mdi-instagram" href="{{ gp247_config('instagram_url') }}"></a></li>
                        @endif
                        @if (gp247_config('youtube_url'))
                        <li><a class="icon mdi mdi-youtube-play" href="{{ gp247_config('youtube_url') }}"></a></li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-4 col-xl-3 wow fadeInRight" data-wow-delay=".1s">
                <h4 class="footer-classic-title">{{ gp247_language_render('about.page_title') }}</h4>
                <ul class="contacts-creative">
                  <li>
                    <div class="unit unit-spacing-sm flex-column flex-md-row">
                      <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                      <div class="unit-body"><a href="#">{{ gp247_language_render('store.address') }}: {{ gp247_store_info('address', ($storeId ?? null)) }}</a></div>
                    </div>
                  </li>
                  <li>
                    <div class="unit unit-spacing-sm flex-column flex-md-row">
                      <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                      <div class="unit-body"><a href="tel:#">{{ gp247_language_render('store.hotline') }}: {{ gp247_store_info('long_phone', ($storeId ?? null)) }}</a></div>
                    </div>
                  </li>
                  <li>
                    <div class="unit unit-spacing-sm flex-column flex-md-row">
                      <div class="unit-left"><span class="icon mdi mdi-email-outline"></span></div>
                      <div class="unit-body"><a href="mailto:#{{ gp247_store_info('email', ($storeId ?? null)) }}">{{ gp247_language_render('store.email') }}: {{ gp247_store_info('email', ($storeId ?? null)) }}</a></div>
                    </div>
                  </li>
                  <li>

                    <form class="rd-form-inline rd-form-inline-2"  method="post" action="{{ gp247_route_front('front.subscribe') }}">
                        @csrf
                          <div class="form-wrap">
                            <input class="form-input" id="subscribe-form-2-email" type="email" name="subscribe_email" required/>
                            <label class="form-label" for="subscribe-form-2-email">{{ gp247_language_render('front.email') }}</label>
                          </div>
                          <div class="form-button">
                            <button class="button button-icon-2 button-zakaria button-primary" type="submit" title="{{ gp247_language_render('subscribe.title') }}">
                              <span class="fl-bigmug-line-paper122"></span>
                            </button>
                          </div>
                        </form>
                  </li>
                </ul>
              </div>
              <div class="col-lg-4 wow fadeInRight" data-wow-delay=".2s">
                <h4 class="footer-classic-title"> {{ gp247_language_render('front.link_useful') }}</h4>
                <!-- RD Mailform-->
                <ul class="contacts-creative">
                  @if (!empty(gp247_link_collection()['footer']))
                  @foreach (gp247_link_collection()['footer'] as $url)
                    @if ($url['type'] != 'collection')
                      <li class="rd-nav-item">
                        <a class="rd-nav-link" {{ ($url['data']['target'] =='_blank')?'target=_blank':''  }}
                            href="{{ gp247_url_render($url['data']['url']) }}">{{ gp247_language_render($url['data']['name']) }}</a>
                      </li>
                    @endif
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="footer-classic-panel">
          <div class="container">
            <div class="row row-10 align-items-center justify-content-sm-between">
              <div class="col-md-auto">
                <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span>&nbsp;</span><span>{{ gp247_store_info('title', ($storeId ?? null)) }}</span><span>.&nbsp; All rights reserved</span></p>
              </div>
              @if (gp247_config('fanpage_url'))
              <div class="col-md-auto order-md-1"> <a target="_blank"
                href="{{ gp247_config('fanpage_url') }}">Fanpage FB</a>
              </div>
              @endif
              @if (!gp247_config('hidden_copyright_footer'))
              <div class="col-md-auto">
                    Power by <a href="{{ config('gp247.homepage') }}">{{ config('gp247.name') }} {{ config('gp247.sub-version') }}</a>
              </div>
              @endif
            </div>
          </div>
        </div>
      </footer>