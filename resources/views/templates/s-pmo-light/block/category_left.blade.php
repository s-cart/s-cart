@php
$categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
@endphp
@if ($categoriesTop->count())
<div class="aside-item col-sm-6 col-md-5 col-lg-12">
  <h6 class="aside-title">{{ sc_language_render('front.categories') }}</h6>
  <ul class="list-shop-filter">
    @foreach ($categoriesTop as $key => $category)
    <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->title }}</a></li>
    @endforeach
  </ul>
</div>
@endif