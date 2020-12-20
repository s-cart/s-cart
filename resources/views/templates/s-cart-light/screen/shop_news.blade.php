@php
/*
$layout_page = news_list
**Variables:**
- $news: paginate
Use paginate: $news->appends(request()->except(['page','_token']))->links()
*/
@endphp


@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default">
    <div class="container">
      <div class="row row-30">
        @if ($news->count())
            @foreach ($news as $newsDetail)
            <div class="col-sm-6 col-lg-4">
                <!-- Post Classic-->
                <article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $newsDetail->getUrl() }}">
                    <img src="{{ asset($newsDetail->getThumb()) }}" alt="" width="370" height="239"></a>
                  <div class="post-classic-content">
                    <div class="post-classic-time">
                      <time datetime="{{ $newsDetail->created_at }}">{{ $newsDetail->created_at }}</time>
                    </div>
                    <h5 class="post-classic-title"><a href="{{ $newsDetail->getUrl() }}">{{ $newsDetail->title }}</a></h5>
                    <p class="post-classic-text">
                        {{ $newsDetail->description }}
                    </p>
                  </div>
                </article>
              </div>
            @endforeach

            <div class="pagination-wrap">
                <!-- Bootstrap Pagination-->
                <nav aria-label="Page navigation">
                    {{ $news->links() }}
                </nav>
              </div>

        @else
            {!! trans('front.no_data') !!}
        @endif
      </div>

    </div>
  </section>

{{-- Render block include view --}}
@if ($includePathView = config('sc_include_view.news_list', []))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render block include view --}}

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
        <li class="active">{{ $title ?? '' }}</li>
      </ul>
    </div>
  </div>
</section>
@endsection
{{-- //breadcrumb --}}

@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
  {{-- Render block include script --}}
  @if ($includePathScript = config('sc_include_script.news_list', []))
  @foreach ($includePathScript as $script)
    @if (view()->exists($script))
      @include($script)
    @endif
  @endforeach
  @endif
  {{--// Render block include script --}}
@endpush