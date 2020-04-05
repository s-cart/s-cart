  @php
    $categories = $modelCategory->start()->getList(['status' => 1]);
    $categoriesTop = $modelCategory->start()->getCategoryTop()->getData();
  @endphp
  
  @if ($categoriesTop->count())
              <h2>{{ trans('front.categories') }}</h2>
              <div class="panel-group category-products" id="accordian">
              @foreach ($categoriesTop as $key =>  $category)
                @if (!empty($categories[$category->id]))
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordian" href="#{{ $key }}">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                      </a>
                      <a href="{{ $category->getUrl() }}">  {{ $category->title }}</a>
                    </h4>
                  </div>
                  <div id="{{ $key }}" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul>
                        @foreach ($categories[$category->id] as $cateChild)
                            <li>
                                - <a href="{{ $cateChild->getUrl() }}">{{ $cateChild->name }}</a>
                                <ul>
                                  @if (!empty($categories[$cateChild->id]))
                                    @foreach ($categories[$cateChild->id] as $cateChild2)
                                        <li>
                                            -- <a href="{{ $cateChild2->getUrl() }}">{{ $cateChild2->name }}</a>
                                        </li>
                                    @endforeach
                                  @endif
                                </ul>
                            </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
                @else
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <a href="{{ $category->getUrl() }}"><h4 class="panel-title"><a href="{{ $category->getUrl() }}">{{ $category->title }}</a></h4></a>
                    </div>
                  </div>
               @endif
            @endforeach
              </div>
  @endif
