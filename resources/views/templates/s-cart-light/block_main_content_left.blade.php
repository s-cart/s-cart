<!--main left-->
  @section('block_main_content_left')
  <div class="col-lg-4 col-xl-3">
    <div class="aside row row-30 row-md-50 justify-content-md-between">

      @yield('blockStoreLeft')

      <!--Module left -->
      @isset ($sc_blocksContent['left'])
      @foreach ( $sc_blocksContent['left'] as $layout)
      @php
      $arrPage = explode(',', $layout->page)
      @endphp
      @if (empty($layout->page) || $layout->page == '*' || (isset($layout_page) && in_array($layout_page, $arrPage)))
      @if ($layout->type =='html')
      {!! $layout->text !!}
      @elseif($layout->type =='view')
      @if (view()->exists($sc_templatePath.'.block.'.$layout->text))
      @include($sc_templatePath.'.block.'.$layout->text)
      @endif
      @endif
      @endif
      @endforeach
      @endisset
      <!--//Module left -->

    </div>
  </div>
  @show
<!--//main left-->