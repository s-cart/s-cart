@php
/*
$layout_page = shop_news
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
                    <img src="{{ sc_file($newsDetail->getThumb()) }}" alt="" width="370" height="239"></a>
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
            {!! sc_language_render('front.data_notfound') !!}
        @endif
      </div>

    </div>
  </section>

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