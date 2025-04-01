@php
    $type_w = $type_w ?? ''; //weight
    $type_t = $type_t ?? ''; //type
    $type_a = $type_a ?? ''; //arrow
    $class ?? '';
@endphp

@if ($type_w == 'auto')
    @php
        $class = $class.' ';
    @endphp
@endif

@if ($type_t == 'cart')
    @php
        $class = $class.' button-secondary button-zakaria';
    @endphp
@elseif ($type_t == 'buy')
    @php
    $class = $class.' button-secondary';
    @endphp
@endif

@if ($type_a == 'back')
    @php
        $class = $class.' ';
    @endphp
@elseif ($type_a == 'next')
    @php
    $class = $class.' ';
    @endphp
@endif

@php
    $class = " button button-lg ".$class;
@endphp
<button {!! $html ?? '' !!} style="{!! $css ?? '' !!}" class="{!! $class !!}" type="{!! $type !!}" {!! !empty($id) ? 'id= "'.$id.'"' : '' !!}>{!! $name ?? 'Button' !!}</button>