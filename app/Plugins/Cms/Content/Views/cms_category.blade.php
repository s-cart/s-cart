@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default">
  <div class="container">
    <div class="row row-30">
      @if ($entries->count())
          @foreach ($entries as $entryDetail)
          <div class="col-sm-6 col-lg-4">
              <!-- Post Classic-->
              <article class="post post-classic box-md"><a class="post-classic-figure" href="{{ $entryDetail->getUrl() }}">
                  <img src="{{ asset($entryDetail->getThumb()) }}" alt="" width="370" height="239"></a>
                <div class="post-classic-content">
                  <h5 class="post-classic-title"><a href="{{ $entryDetail->getUrl() }}">{{ $entryDetail->title }}</a></h5>
                  <p class="post-classic-text">
                      {{ $entryDetail->description }}
                  </p>
                </div>
              </article>
            </div>
          @endforeach

          <div class="pagination-wrap">
              <!-- Bootstrap Pagination-->
              <nav aria-label="Page navigation">
                  {{ $entries->links() }}
              </nav>
            </div>

      @else
          {!! trans('front.no_data') !!}
      @endif
    </div>

  </div>
</section>
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
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
