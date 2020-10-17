@if (!empty($listSubCategory) && $listSubCategory->count())
<div class="aside-item col-sm-6 col-md-5 col-lg-12">
  <h6 class="aside-title">{{ trans('front.categories') }}</h6>
  <ul class="list-shop-filter">
    @foreach ($listSubCategory as $key => $category)
    <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->getTitle() }}</a></li>
    @endforeach
  </ul>
</div>
@endif