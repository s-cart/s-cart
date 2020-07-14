@php
$brands = $modelBrand->start()->getData();
@endphp

@if (!empty($brands))
<div class="widget widget-brand mb-4 pb-4 border-bottom">
  <h4 class="widget-title mb-3">{{ trans('front.brands') }}</h4>
    <div class="custom-control custom-checkbox mb-2" style="display: inline-grid;">
      @foreach ($brands as $key => $brand)
        @php 
          $key++;
        @endphp
        <input type="checkbox" class="custom-control-input" id="brandCheck{{$key}}">
        <label class="custom-control-label" for="brandCheck{{$key}}"> {{ $brand->name }}</label>
      @endforeach
    </div>
  </div>

@endif
