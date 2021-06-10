{{-- Module banner --}}
@isset ($sc_blocksContent['banner_top'])
@foreach ( $sc_blocksContent['banner_top'] as $layout)
    @php
    $arrPage = explode(',', $layout->page)
    @endphp
    @if ($layout->page == '*' || (isset($layout_page) && in_array($layout_page, $arrPage)))
        @if ($layout->type =='html')
        {!! $layout->text !!}
        @elseif($layout->type =='view')
            @includeIf($sc_templatePath.'.block.'.$layout->text)
        @endif
    @endif
@endforeach
@endisset
{{-- //Module banner --}}


{{-- Module top --}}
@isset ($sc_blocksContent['top'])
@foreach ( $sc_blocksContent['top'] as $layout)
@php
$arrPage = explode(',', $layout->page)
@endphp
@if ($layout->page == '*' || (isset($layout_page) && in_array($layout_page, $arrPage)))
    @if ($layout->type =='html')
    {!! $layout->text !!}
    @elseif($layout->type =='view')
        @includeIf($sc_templatePath.'.block.'.$layout->text)
    @endif
@endif
@endforeach
@endisset
{{-- //Module top --}}

@section('breadcrumb')
    @include($sc_templatePath.'.common.breadcrumb')
@show

<!--Notice -->
@include($sc_templatePath.'.common.notice')
<!--//Notice -->