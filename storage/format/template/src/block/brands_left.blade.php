  @php
    $brands = $modelBrand->start()->getData()
  @endphp
  
  @if (!empty($brands))
              <div class="brands_products"><!--brands_products-->
                <h2>{{ trans('front.brands') }}</h2>
                <div class="brands-name">
                  <ul class="nav nav-pills nav-stacked">
                    @foreach ($brands as $brand)
                      <li><a href="{{ $brand->getUrl() }}"> {{ $brand->name }}</a></li>
                    @endforeach
                  </ul>
                </div>
              </div><!--/brands_products-->
  @endif
