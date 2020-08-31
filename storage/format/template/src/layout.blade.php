@if (sc_store('active') == '0')
    @include($sc_templatePath . '.maintenance')
@else 

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{$title??sc_store('title')}}</title>
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png" sizes="16x16">
    <meta property="og:image" content="{{ !empty($og_image)?asset($og_image):asset('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??sc_store('title') }}" />
    <meta property="og:description" content="{{ $description??sc_store('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">


<!--Module meta -->
  @isset ($blocksContent['meta'])
      @foreach ( $blocksContent['meta']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module meta -->

<!-- css default for item s-cart -->
@include($sc_templatePath.'.common.css')
<!--//end css defaut -->

  <link href="{{ asset($sc_templateFile.'/css/main.css')}}" rel="stylesheet">


  <!--Module header -->
  @isset ($blocksContent['header'])
      @foreach ( $blocksContent['header']  as $layout)
      @php
        $arrPage = explode(',', $layout->page)
      @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module header -->

</head>
<!--//head-->
<body>

  {{-- Block header --}}
  @section('block_header')
    @include($sc_templatePath.'.block_header')
  @show
  {{--// Block header --}}

  <main role="main">
      {{-- Block top --}}
      @section('block_top')
        @include($sc_templatePath.'.block_top')
      @show
      {{-- //Block top --}}

      <section>
      {{-- Block main --}}
      @section('block_main')
          @include($sc_templatePath.'.block_main_content_left')
          @include($sc_templatePath.'.block_main_content_center')
          @include($sc_templatePath.'.block_main_content_right')
      @show
      {{-- //Block main --}}
      </section>

      {{-- Block bottom --}}
      @section('block_bottom')
        @include($sc_templatePath.'.block_bottom')
      @show
      {{-- //Block bottom --}}
  </main>
  {{-- Block footer --}}
  @section('block_footer')
    @include($sc_templatePath.'.block_footer')
  @show
  {{-- //Block footer --}}

<script src="{{ asset($sc_templateFile.'/js/main.js')}}"></script>

@stack('scripts')
<!-- js default for item s-cart -->
@include($sc_templatePath.'.common.js')
<!--//end js defaut -->


</body>
</html>
@endif