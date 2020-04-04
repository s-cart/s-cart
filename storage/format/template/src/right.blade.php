<!--Module right -->
  @isset ($blocksContent['right'])
      @foreach ( $blocksContent['right']  as $layout)
        @if ($layout->page == null ||  $layout->page =='*' || $layout->page =='' || (isset($layout_page) && in_array($layout_page, $layout->page) ) )
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
<!--//Module right -->
