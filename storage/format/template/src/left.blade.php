<!--main left-->
<div class="col-sm-3">
   @section('left')
        <div class="left-sidebar">
      <!--Module left -->
          @isset ($blocksContent['left'])
              @foreach ( $blocksContent['left']  as $layout)
              @php
                $arrPage = explode(',', $layout->page)
              @endphp
                @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
                  @if ($layout->type =='html')
                    {!! $layout->text !!}
                  @elseif($layout->type =='view')
                    @if (view()->exists($templatePath.'.block.'.$layout->text))
                     @include($templatePath.'.block.'.$layout->text)
                    @endif
                  @endif
                @endif
              @endforeach
          @endisset
      <!--//Module left -->
      </div>
    @show
</div>
<!--//main left-->
