@php
/*
$layout_page = home
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')

{{-- Render include view --}}
@if (!empty($layout_page && $includePathView = config('sc_include_view.'.$layout_page, [])))
@foreach ($includePathView as $view)
   @includeIf($view)
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
   @includeIf($script)
@endforeach
@endif
{{--// Render include script --}}

@endpush
