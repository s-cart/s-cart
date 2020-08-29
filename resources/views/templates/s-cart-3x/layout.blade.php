@if (sc_store('active') == '0')
    @include($sc_templatePath . '.maintenance')
@else 

<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CLato%7CKalam:300,400,700">
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

    <!-- css default for item s-cart -->
    @include($sc_templatePath.'.common.css')
    <!--//end css defaut -->

    <!--Module meta -->
    @isset ($sc_blocksContent['meta'])
    @foreach ( $sc_blocksContent['meta'] as $layout)
    @php
    $arrPage = explode(',', $layout->page)
    @endphp
    @if ($layout->page == '*' || (isset($layout_page) && in_array($layout_page, $arrPage)))
    @if ($layout->type =='html')
    {!! $layout->text !!}
    @endif
    @endif
    @endforeach
    @endisset
    <!--//Module meta -->
    <!-- css default for item s-cart -->
    <!--//end css defaut -->

    <link rel="stylesheet" href="{{ asset($sc_templateFile.'/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset($sc_templateFile.'/css/fonts.css')}}">
    <link rel="stylesheet" href="{{ asset($sc_templateFile.'/css/style.css')}}">
    <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
    @stack('styles')
  </head>
<body>
    <div class="ie-panel">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="{{ asset($sc_templateFile.'/images/ie8-panel/warning_bar_0000_us.jpg')}}" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.">
        </a>
    </div>

    <div class="page">
        {{-- Block header --}}
        @section('block_header')
        @include($sc_templatePath.'.block_header')
        @show
        {{--// Block header --}}

        {{-- Block top --}}
        @section('block_top')
        @include($sc_templatePath.'.block_top')
        @show
        {{-- //Block top --}}

        {{-- Block main --}}
        @section('block_main')
        <section class="section section-xxl bg-default text-md-left">
            <div class="container">
                <div class="row row-50">
                    @section('block_main_content')
                    @include($sc_templatePath.'.block_main_content_left')
                    @include($sc_templatePath.'.block_main_content_center')
                    @include($sc_templatePath.'.block_main_content_right')
                    @show
                </div>
            </div>
        </section>
        @show
        {{-- //Block main --}}

        @yield('news')

        {{-- Block bottom --}}
        @section('block_bottom')
        @include($sc_templatePath.'.block_bottom')
        @show
        {{-- //Block bottom --}}

        {{-- Block footer --}}
        @section('block_footer')
        @include($sc_templatePath.'.block_footer')
        @show
        {{-- //Block footer --}}

    </div>

    <div id="sc-loading">
        <div class="sc-overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw "></i></div>
    </div>

    <script src="{{ asset($sc_templateFile.'/js/core.min.js')}}"></script>
    <script src="{{ asset($sc_templateFile.'/js/script.js')}}"></script>
    <!-- js default for item s-cart -->
    @include($sc_templatePath.'.common.js')
    <!--//end js defaut -->
    @stack('scripts')

</body>
</html>
@endif