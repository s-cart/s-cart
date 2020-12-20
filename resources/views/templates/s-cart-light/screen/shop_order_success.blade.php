@php
/*
$layout_page = shop_order_success
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">
<h6 class="aside-title">{{ $title }}</h6>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="title-page">{{ $title }}</h2>
        </div>
        <div class="col-md-12 text-success">
            <h2>{{ trans('order.success.msg') }}</h2>
            <h3>{{ trans('order.success.order_info',['order_id'=>session('orderID')]) }}</h3>
        </div>
    </div>
</div>


{{-- Render block include view --}}
@if ($includePathView = config('sc_include_view.shop_order_success', []))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render block include view --}}

@endsection

@section('breadcrumb')
@endsection

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
  {{-- Render block include script --}}
  @if ($includePathScript = config('sc_include_script.shop_order_success', []))
  @foreach ($includePathScript as $script)
    @if (view()->exists($script))
      @include($script)
    @endif
  @endforeach
  @endif
  {{--// Render block include script --}}
@endpush
