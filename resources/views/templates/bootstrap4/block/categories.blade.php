  @php
    $categories = $modelCategory->start()->getList(['status' => 1]);
    $categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
  @endphp

@if ($categoriesTop->count())

    <div class="shadow-sm p-5">
      <div class="widget widget-categories mb-4 pb-4 border-bottom">
        <h4 class="widget-title mb-3">{{ trans('front.categories') }}</h4>
        <div id="accordion" class="accordion">
          @foreach ($categoriesTop as $key => $category)
            @php
              $key++;
            @endphp
            @if (!empty($categories[$category->id]))
            <div class="card border-0 mb-3">
              <div class="card-header">
                <h6 class="mb-0">
                  <a class="link-title" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="true">{{$category->title}}</a>
                </h6>
              </div>
              <div id="collapse{{$key}}" class="collapse {{$key==1?'show':''}}" data-parent="#accordion">
                <div class="card-body text-muted">
                  <ul class="list-unstyled">
                    @foreach ($categories[$category->id] as $cateChild)
                    <li>
                        <a href="{{ $cateChild->getUrl() }}">{{ $cateChild->title }}</a>
                        @if (!empty($categories[$cateChild->id]))
                          <ul>
                            @foreach ($categories[$cateChild->id] as $cateChild2)
                                <li>
                                    <a href="{{ $cateChild2->getUrl() }}">{{ $cateChild2->title }}</a>
                                </li>
                            @endforeach
                          </ul>
                        @endif
                    </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
            @endif
          @endforeach
        </div>
      </div>
      
@endif