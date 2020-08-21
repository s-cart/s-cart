@php
/*
$layout_page = news_list
$news: paginate
Use paginate: $news->appends(request()->except(['page','_token']))->links()
$products: paginate
Use paginate: $products->appends(request()->except(['page','_token']))->links()
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section >
<div class="container">
    <div class="row">
        <h2 class="title text-center">{{ $title }}</h2>
        <!-- Center colunm-->
          <div class="center_column">
            <ul class="blog-posts">
@foreach ($news as $newsDetail)
              <li class="post-item">
                <article class="entry">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="entry-thumb image-hover2"> <a href="{{ $newsDetail->getUrl() }}">
                        <figure><img src="{{ asset($newsDetail->getThumb()) }}" alt="{{ $newsDetail->title }}" alt="Blog"></figure>
                        </a> </div>
                    </div>
                    <div class="col-sm-9">
                      <h3 class="entry-title"><a href="{{ $newsDetail->getUrl() }}">{{ $newsDetail->title }}</a></h3>
                      <div class="entry-meta-data"> <span class="author">  <span class="date"><i class="pe-7s-date"></i>&nbsp; {{ $newsDetail->created_at }}</span> </div>
                      <div class="entry-excerpt">{{ $newsDetail->description }}</div>
                      <a href="{{ $newsDetail->getUrl() }}" class="button read-more">{{ trans('front.view_more') }}&nbsp; <i class="fa fa-angle-double-right"></i></a> </div>
                  </div>
                </article>
                <hr>
              </li>
@endforeach
            </ul>
            <div class="sortPagiBar">
              <div class="pagination-area " >
                    {{ $news->links() }}
              </div>
            </div>
        </div>
      <!-- ./row-->
    </div>
  </section>
@endsection

@section('breadcrumb')
    <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection

@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
      {{-- script --}}
@endpush