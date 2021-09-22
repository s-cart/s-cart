@isset ($sc_blocksContent['center'])
  @foreach ( $sc_blocksContent['center']  as $layout)
    @php
    $arrPage = explode(',', $layout->page)
    @endphp
    @if (empty($layout->page) ||  $layout->page =='*' ||  (isset($layout_page) && in_array($layout_page, $arrPage) ) )
      @if ($layout->type =='html')
        {!! $layout->text !!}
      @elseif($layout->type =='view')
        @includeIf($sc_templatePath.'.block.'.$layout->text)
      @endif
    @endif
  @endforeach
@endisset