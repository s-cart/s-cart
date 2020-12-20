@php
/*
$layout_page = news_detail
**Variables:**
- $news: no paginate
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {!! sc_html_render($news->content) !!}
            </div>
        </div>
    </div>
</section>
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
@php
$bannerBreadcrumb = $modelBanner->start()->getBreadcrumb()->getData()->first();
@endphp
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{ asset($bannerBreadcrumb['image'] ?? '') }}">
    <div class="material-parallax parallax">
      <img src="{{ asset($bannerBreadcrumb['image'] ?? '') }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);">
    </div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
        <li><a href="{{ sc_route('news') }}">{{ trans('front.blog') }}</a></li>
        <li class="active">{{ $title ?? '' }}</li>
      </ul>
    </div>
  </div>
</section>

{{-- Render block include view --}}
@if ($includePathView = config('sc_include_view.news_detail', []))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render block include view --}}

@endsection
{{-- //breadcrumb --}}

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
  {{-- Render block include script --}}
  @if ($includePathScript = config('sc_include_script.news_detail', []))
  @foreach ($includePathScript as $script)
    @if (view()->exists($script))
      @include($script)
    @endif
  @endforeach
  @endif
  {{--// Render block include script --}}
@endpush
