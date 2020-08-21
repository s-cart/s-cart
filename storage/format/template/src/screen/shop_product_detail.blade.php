@php
/*
$layout_page = product_detail
$product: no paginate
$productRelation: no paginate
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
          <div class="product-details"><!--product-details-->
            <div class="col-sm-6">


              <div id="product-detail-image" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                      <div class="view-product item active"  data-slide-number="0">
                        <img src="{{ asset($product->getImage()) }}" alt="">
                      </div>
                    @if ($product->images->count())
                       @foreach ($product->images as $key=>$image)
                        <div class="view-product item"  data-slide-number="{{ $key + 1 }}">
                          <img src="{{ asset($image->getImage()) }}" alt="">
                        </div>
                        @endforeach
                    @endif
                    </div>
                  {{-- </div> --}}
              </div>
              @if ($product->images->count())
                    <!-- Controls -->
                    <a class="left item-control" style="display: inherit;" href="#product-detail-image" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="right item-control" href="#product-detail-image" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                    </a>
                @endif
            </div>

        <form id="buy_block" action="{{ sc_route('cart.add') }}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="product_id" id="product-detail-id" value="{{ $product->id }}" />
            <div class="col-sm-6">
              <div class="product-information"><!--/product-information-->
                @if ($product->price != $product->getFinalPrice() && $product->kind != SC_PRODUCT_GROUP)
                <img src="{{ asset($sc_templateFile.'/images/home/sale2.png') }}" class="newarrival" alt="" />
                @elseif($product->kind == SC_PRODUCT_BUILD)
                <img src="{{ asset($sc_templateFile.'/images/home/bundle2.png') }}" class="newarrival" alt="" />
                @elseif($product->kind == SC_PRODUCT_GROUP)
                <img src="{{ asset($sc_templateFile.'/images/home/group2.png') }}" class="newarrival" alt="" />
                @endif

                <h2  id="product-detail-name">{{ $product->name }}</h2>
                <p>SKU: <span  id="product-detail-model">{{ $product->sku }}</span></p>
                <div id="product-detail-price">
                  {!! $product->showPriceDetail() !!}
                </div>

                @if ($product->kind == SC_PRODUCT_GROUP)
                <span id="product-detail-cart-group" style="display:none">
                  <label>{{ trans('product.quantity') }}:</label>
                  <input type="number" name="qty" value="1" min="1" />
                  <button type="submit" class="btn btn-fefault cart">
                    <i class="fa fa-shopping-cart"></i>
                    {{trans('front.add_to_cart')}}
                  </button>
                </span>                      
                @else ($product->allowSale())
                <span>
                  <label>{{ trans('product.quantity') }}:</label>
                  <input type="number" name="qty" value="1" min="1" />
                  <button type="submit" class="btn btn-fefault cart">
                    <i class="fa fa-shopping-cart"></i>
                    {{trans('front.add_to_cart')}}
                  </button>
                </span>  
                @endif


                <div  id="product-detail-attr">
                  @if ($product->attributes())
                  {!! $product->renderAttributeDetails() !!}
                  @endif
                </div>

                @if (sc_config('product_stock'))
                <b>{{ trans('product.stock_status') }}:</b>
                <span id="stock_status">
                    @if($product->stock <=0 && !sc_config('product_buy_out_of_stock'))
                    {{ trans('product.out_stock') }}
                    @else
                    {{ trans('product.in_stock') }}
                    @endif
                </span>
                <br>
                @endif


                @if (sc_config('product_available') && $product->date_available >= date('Y-m-d H:i:s'))
                  <b>{{ trans('product.date_available') }}:</b>
                  <span id="product-detail-available">
                    {{ $product->date_available }}
                  </span>
                  <br>
                @endif
                
              <div class="description">
                {{ $product->description }}
              </div>

                @if (sc_config('product_brand') && !empty($product->brand->name))
                  <b>{{ trans('product.brand') }}:</b> <span id="product-detail-brand">{{ empty($product->brand->name)?'None':$product->brand->name }}</span><br>
                @endif


              @if ($product->kind == SC_PRODUCT_GROUP)
              <div class="products-group">
                @php
                  $groups = $product->groups
                @endphp
                <b>{{ trans('product.groups') }}</b>:<br>
                @foreach ($groups as $group)
                  <span class="sc-product-group" data-id="{{ $group->product_id }}">{!! sc_image_render($group->product->image,'','',$group->product->name) !!}</span>
                @endforeach
              </div>
              @endif

              @if ($product->kind == SC_PRODUCT_BUILD)
              <div class="products-group">
                @php
                  $builds = $product->builds
                @endphp
                <b>{{ trans('product.builds') }}</b>:<br>
                <span class="sc-product-build">{!! sc_image_render($product->image,'','',$product->name) !!} = </span>
                @foreach ($builds as $k => $build)
                  {!! ($k)?'<i class="fa fa-plus" aria-hidden="true"></i>':'' !!} <span class="sc-product-build">{{ $build->quantity }} x <a target="_new" href="{{ $build->product->getUrl() }}">{!! sc_image_render($build->product->image,'','',$build->product->name) !!}</a></span>
                @endforeach
              </div>
              @endif


              </div><!--/product-information-->
            </div>
          </div><!--/product-details-->
        </form>

          <div class="category-tab shop-details-tab"><!--category-tab-->
            <div class="col-sm-12">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">{{ trans('product.description') }}</a></li>
              </ul>
            </div>
            <div class="tab-content">
              <div class="tab-pane fade  active in" id="product-detail-content" >
                {!! sc_html_render($product->content) !!}
              </div>
            </div>
          </div><!--/category-tab-->
@if ($productRelation->count())
          <div class="recommended_items"><!--recommended_items-->
            <h2 class="title text-center">{{ trans('front.recommended_items') }}</h2>

            <div id="recommended-item-carousel" class="carousel slide">
              <div class="carousel-inner">
               @foreach ($productRelation as  $key => $product_rel)
                @if ($key % 4 == 0)
                  <div class="item {{  ($key ==0)?'active':'' }}">
                @endif
                  <div class="col-sm-3">
                    <div class="product-image-wrapper product-single">
                      <div class="single-products   product-box-{{ $product_rel->id }}">
                          <div class="productinfo text-center">
                            <a href="{{ $product_rel->getUrl() }}"><img src="{{ asset($product_rel->getThumb()) }}" alt="{{ $product_rel->name }}" /></a>
                        {!! $product_rel->showPrice() !!}
                            <a href="{{ $product_rel->getUrl() }}"><p>{{ $product_rel->name }}</p></a>
                          </div>
                          @if ($product_rel->price != $product_rel->getFinalPrice())
                          <img src="{{ asset($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" />
                          @elseif($product_rel->type == 1)
                          <img src="{{ asset($sc_templateFile.'/images/home/new.png') }}" class="new" alt="" />
                          @endif
                      </div>
                    </div>
                  </div>
                @if ($key % 4 == 3)
                  </div>
                @endif
               @endforeach
              </div>
            </div>
          </div><!--/recommended_items-->
@endif


@endsection

@section('breadcrumb')
@endsection

@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
<script type="text/javascript">
  $('.sc-product-group').click(function(event) {
    if($(this).hasClass('active')){
      return;
    }
    $('.sc-product-group').removeClass('active');
    $(this).addClass('active');
    var id = $(this).data("id");
      $.ajax({
          url:'{{ route("product.info") }}',
          type:'POST',
          dataType:'json',
          data:{id:id,"_token": "{{ csrf_token() }}"},
          beforeSend: function(){
              $('#loading').show();
          },
          success: function(data){
            //console.log(data);
            var showImages = '<div class="carousel-inner">' +
              '<div class="view-product item active"  data-slide-number="0">'+
                  '<img src="'+data.image+'" alt="">'+
              '</div>';
          if(data.subImages.length) {
              $.each(data.subImages, function( index, value ) {
                  showImages +='<div class="view-product item"  data-slide-number="'+(index + 1)+ '">'+
                      '<img src="'+value+'" alt="">'+
                      '</div>'
                });
          }
          showImages +='</div>';
          if(data.subImages.length) {
              showImages += '<a class="left item-control" href="#similar-product" data-slide="prev">'+
                  '<i class="fa fa-angle-left"></i></a>'+
                  '<a class="right item-control" href="#similar-product" data-slide="next">'+
                  '<i class="fa fa-angle-right"></i>'+
                  '</a>';
          }
            $('#product-detail-cart-group').show();
            $('#product-detail-name').html(data.name);
            $('#product-detail-model').html(data.sku);
            $('#product-detail-price').html(data.showPrice);
            $('#product-detail-brand').html(data.brand_name);
            $('#product-detail-image').html(showImages);
            $('#product-detail-available').html(data.availability);
            $('#product-detail-id').val(data.id);
            $('#product-detail-image').carousel();
            $('#loading').hide();
            window.history.pushState("", "", data.url);            
          }
      });

  });
</script>
@endpush
