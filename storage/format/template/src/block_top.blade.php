
<!--Module banner -->
@isset ($blocksContent['banner_top'])
@foreach ( $blocksContent['banner_top']  as $layout)
@php
  $arrPage = explode(',', $layout->page)
@endphp
  @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
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
<!--//Module banner -->


<!--Module top -->
@isset ($blocksContent['top'])
@foreach ( $blocksContent['top']  as $layout)
  @php
    $arrPage = explode(',', $layout->page)
  @endphp
  @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
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
<!--//Module top -->

@yield('breadcrumb')

<!--Notice -->
@include($sc_templatePath.'.common.notice')
<!--//Notice -->

<!--fillter-->
@yield('filter')
<!--//fillter-->