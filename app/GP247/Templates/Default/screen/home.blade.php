@php
/*
$layout_page = front_home
*/ 
@endphp

@extends($GP247TemplatePath.'.layout')

@section('block_main')
   {{-- Render include view --}}
   @include($GP247TemplatePath.'.common.include_view')
   {{--// Render include view --}}
@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush
