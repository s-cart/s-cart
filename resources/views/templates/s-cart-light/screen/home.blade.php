@php
/*
$layout_page = home
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
   {{-- Render include view --}}
   @include($sc_templatePath.'.common.include_view')
   {{--// Render include view --}}
@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush
