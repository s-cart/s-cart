      <!-- Page Footer-->
      <footer class="section footer-classic">
          <div class="footer-classic-body section-sm bg-brown-2">
              <div class="container">
                  <div class="footer-fix-container">
                      {{-- logo --}}
                      <a class="footer-fix-logo" href="{{ sc_route('home') }}">
                          <img class="logo-footer" src="{{ sc_file(sc_store('logo', $storeId ?? null)) }}"
                              alt="{{ sc_store('title', $storeId ?? null) }}">
                      </a>

                      <div class="footer-fix-data">
                          {{-- address --}}
                          <div class="footer-fix-address">
                              <h4 class="footer-classic-title footer-fix-title">Address</h4>
                              <a class="" href="#">{{ sc_language_render('store.address') }}:
                                  {{ sc_store('address', $storeId ?? null) }}</a>
                          </div>


                          {{-- contact --}}
                          <div class="footer-fix-contact">
                              <h4 class="footer-classic-title footer-fix-title"> Contact</h4>

                              <a href="tel:{{ sc_store('long_phone', $storeId ?? null) }}">{{ sc_language_render('store.hotline') }}:
                                  {{ sc_store('long_phone', $storeId ?? null) }}</a>

                              <div class="pt-2">
                                  <a href="mailto:{{ sc_store('email', $storeId ?? null) }}">{{ sc_language_render('store.email') }}:
                                      {{ sc_store('email', $storeId ?? null) }}</a>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>
          </div>

          <div class="py-2">
              <div class="container">
                  <div class="row row-10 align-items-center justify-content-sm-between">
                      <div class="col-md-auto">
                          <p class="rights"><span>&copy;&nbsp;</span><span
                                  class="copyright-year"></span><span>&nbsp;</span><span>{{ sc_store('title', $storeId ?? null) }}</span><span>.&nbsp;
                                  All rights reserved</span></p>
                      </div>
                      @if (sc_config('fanpage_url'))
                          <div class="col-md-auto order-md-1"> <a target="_blank"
                                  href="{{ sc_config('fanpage_url') }}">Fanpage FB</a>
                          </div>
                      @endif
                      @if (!sc_config('hidden_copyright_footer'))
                          <div class="col-md-auto">
                              Power by <a href="{{ config('s-cart.homepage') }}">{{ config('s-cart.name') }}
                                  {{ config('s-cart.sub-version') }}</a>
                          </div>
                      @endif
                  </div>
              </div>
          </div>

      </footer>
