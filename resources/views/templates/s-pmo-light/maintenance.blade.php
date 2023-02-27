<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{ sc_language_render('store.maintenance') }}</title>
    <meta property="og:image" content="{{ !empty($og_image)?sc_file($og_image):sc_file('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??sc_store('title') }}" />
    <meta property="og:description" content="{{ $description??sc_store('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <section>
    <div class="container">
      <div class="row">
        <div id="columns" class="container"  style="color:red;text-align: center;">
          {!! sc_store('maintain_content') !!}
        </div>
      </div>
    </div>
  </section>
</body>