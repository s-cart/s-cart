<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="{{ config('app.name')}}">
    <link rel="canonical" href="{{ request()->url() }}" />
    <meta name="description" content="{{ $description ?? gp247_store_info('description') }}">
    <meta name="keywords" content="{{ $keyword ?? gp247_store_info('keyword') }}">
    <title>{{ gp247_language_render('store.maintenance') }}</title>
    <link rel="icon" href="{{ gp247_file(gp247_store_info('icon','GP247/Core/logo/icon.png')) }}" type="image/png" sizes="16x16">
    <meta property="og:image" content="{{ !empty($og_image)?gp247_file($og_image):gp247_file(gp247_store_info('og_image', 'GP247/Core/images/org.jpg')) }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??gp247_store_info('title') }}" />
    <meta property="og:description" content="{{ $description??gp247_store_info('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <section>
    <div class="container">
      <div class="row">
        <div id="columns" class="container"  style="color:red;text-align: center;">
          {!! gp247_store_info('maintain_content') !!}
        </div>
      </div>
    </div>
  </section>
</body>