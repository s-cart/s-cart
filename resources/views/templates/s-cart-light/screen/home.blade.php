@php
/*
$layout_page = home
*/ 
@endphp

@extends($sc_templatePath.'.layout')
@php
$news = $modelNews->start()->setlimit(sc_config('item_top'))->getData();
@endphp

@section('block_main')

{{-- Render include view --}}
@if (!empty($layout_page && $includePathView = config('sc_include_view.'.$layout_page, [])))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render include view --}}
@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')

{{-- Render include script --}}
@if (!empty($layout_page) && $includePathScript = config('sc_include_script.'.$layout_page, []))
@foreach ($includePathScript as $script)
  @if (view()->exists($script))
    @include($script)
  @endif
@endforeach
@endif
{{--// Render include script --}}

@endpush
