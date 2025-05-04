<!DOCTYPE html>
<html class="wide wow-animation" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ config('app.name')}}">
    <link rel="canonical" href="{{ request()->url() }}" />
    <meta name="description" content="{{ $description ?? gp247_store_info('description') }}">
    <meta name="keywords" content="{{ $keyword ?? gp247_store_info('keyword') }}">
    <title>{{$title ?? gp247_store_info('title')}}</title>
    <link rel="icon" href="{{ gp247_file(gp247_store_info('icon','GP247/Core/logo/icon.png')) }}" type="image/png" sizes="16x16">
    <meta property="og:image" content="{{ !empty($og_image)?gp247_file($og_image):gp247_file(gp247_store_info('og_image', 'GP247/Core/images/org.jpg')) }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??gp247_store_info('title') }}" />
    <meta property="og:description" content="{{ $description??gp247_store_info('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700%7CLato%7CKalam:300,400,700">

    <!-- css default for item gp247 -->
    @include($GP247TemplatePath.'.common.css')
    <!--//end css defaut -->

    <!--Module header -->
    {!! gp247_render_block('header', $layout_page ?? null) !!}
    <!--//Module header -->

    <link rel="stylesheet" href="{{ gp247_file($GP247TemplateFile.'/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ gp247_file($GP247TemplateFile.'/css/fonts.css')}}">
    <link rel="stylesheet" href="{{ gp247_file($GP247TemplateFile.'/css/style.css')}}">

    @stack('styles')
  </head>
<body>

    <div class="page">
        {{-- Block block_menu --}}
        @section('block_menu')
            @include($GP247TemplatePath.'.layout.block_menu')
        @show
        {{--// Block block_menu --}}

        {{-- Block top --}}
        @section('block_top')
            <!--Notice -->
            @include($GP247TemplatePath.'.common.notice')
            <!--//Notice -->

            {{-- Module top --}}
            {!! gp247_render_block('top', $layout_page ?? null) !!}
            {{-- //Module top --}}

            <!--Breadcrumb -->
            @section('breadcrumb')
                @include($GP247TemplatePath.'.common.breadcrumb')
            @show
            <!--//Breadcrumb -->

        @show
        {{-- //Block top --}}

        {{-- Block main --}}
        @section('block_main')
            <section class="section section-xxl bg-default text-md-left">
                <div class="container">
                    <div class="row row-50">
                        @section('block_main_content')

                            <!--Block left-->
                            @section('block_main_content_left')
                            <div class="col-lg-4 col-xl-3">
                                <div class="aside row row-30 row-md-50 justify-content-md-between">
                                    <!--Module left -->
                                    {!! gp247_render_block('left', $layout_page ?? null) !!}
                                    <!--//Module left -->
                                </div>
                            </div>
                            @show
                            <!--//Block left-->

                            <!--Block center-->
                            @section('block_main_content_center')
                            <div class="col-lg-9 col-xl-9">
                                {!! gp247_render_block('center', $layout_page ?? null) !!}
                            </div>
                            @show
                            <!--//Block center-->

                            <!--Block right -->
                            @section('block_main_content_right')
                             {!! gp247_render_block('right', $layout_page ?? null) !!}
                            @show
                            <!--//Block right -->

                        @show
                    </div>
                </div>
            </section>
        @show
        {{-- //Block main --}}

        {{-- Block bottom --}}
        @section('block_bottom')
            <!--Module bottom -->
            {!! gp247_render_block('bottom', $layout_page ?? null) !!}
            <!--//Module bottom -->
            @include($GP247TemplatePath.'.layout.block_bottom')
        @show
        {{-- //Block bottom --}}

        {{-- Block footer --}}
        @section('block_footer')
            <!--Module bottom -->
            {!! gp247_render_block('footer', $layout_page ?? null) !!}
            <!--//Module bottom -->
            @include($GP247TemplatePath.'.layout.block_footer')
        @show
        {{-- //Block footer --}}

    </div>

    <div id="gp247-loading">
        <div class="gp247-overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw "></i></div>
    </div>

    <script src="{{ gp247_file($GP247TemplateFile.'/js/core.min.js')}}"></script>
    <script src="{{ gp247_file($GP247TemplateFile.'/js/script.js')}}"></script>
    
    <!-- js default for item gp247 -->
    @include($GP247TemplatePath.'.common.js')
    <!--//end js defaut -->
    @stack('scripts')

</body>
</html>