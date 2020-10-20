@section('block_main_content_right')
<!--Module right -->
@isset ($sc_blocksContent['right'])
@foreach ( $sc_blocksContent['right']  as $layout)
  @php
  $arrPage = explode(',', $layout->page)
  @endphp
  @if (empty($layout->page) ||  $layout->page =='*' ||  (isset($layout_page) && in_array($layout_page, $arrPage) ) )
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
<!--//Module right -->
@show