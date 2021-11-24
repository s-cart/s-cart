<!--Render block-->
@php
    $positionBlock = $positionBlock ?? '';
@endphp
@isset ($sc_blocksContent[$positionBlock])
    @foreach ( $sc_blocksContent[$positionBlock] as $layout)
        @php
        $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' || (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @elseif($layout->type =='view')
                @includeIf($sc_templatePath.'.block.'.$layout->text)
            @elseif($layout->type =='page')
            <section class="section section-xxl bg-default">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                {!! sc_html_render($modelPage->start()->getDetail($layout->text, $type = 'alias', $checkActive = 0)->content ?? '') !!}
                        </div>
                    </div>
                </div>
            </section>
            @endif
        @endif
    @endforeach
@endisset
@php
    unset($positionBlock)
@endphp
<!--//Render block-->