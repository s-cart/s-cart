<!--Render block-->
@php
    $positionBlock = $positionBlock ?? '';
    $GP247LayoutBlock = gp247_front_layout_block();
@endphp
@isset ($GP247LayoutBlock[$positionBlock])
    @foreach ( $GP247LayoutBlock[$positionBlock] as $layout)
        @php
        $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' || (isset($layout_page) && in_array($layout_page, $arrPage)))
            @if ($layout->type =='html')
                {!! $layout->text !!}
            @elseif($layout->type =='view')
                @includeIf($GP247TemplatePath.'.blocks.'.$layout->text)
            @elseif($layout->type =='page')
                <section class="section section-xxl bg-default">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                            {!! gp247_html_render($modelPage->start()->getDetail($layout->text, $type = 'alias', $checkActive = 0)->content ?? '') !!}
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