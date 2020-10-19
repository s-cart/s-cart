@php
$storeId = empty($storeId) ? config('app.storeId') : $storeId;
if(isset($modelCategoryStore)) {
  $listCategoryStore = $modelCategoryStore->start()->setStore($storeId)->getData();
}
@endphp

@if (!empty($listCategoryStore) && $listCategoryStore->count())
<div class="aside-item col-sm-6 col-md-5 col-lg-12">
  <h6 class="aside-title">{{ trans('front.sub_categories') }}</h6>
  <ul class="list-shop-filter">
    @foreach ($listCategoryStore as $key => $category)
    <li class="product-minimal-title active"><a href="{{ $category->getUrl() }}"> {{ $category->getTitle() }}</a></li>
    @endforeach
  </ul>
</div>
@endif