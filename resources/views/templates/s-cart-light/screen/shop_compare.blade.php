@php
/*
$layout_page = shop_compare
**Variables:**
- $compare: no paginate
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
<div class="col-lg-8 col-xl-9">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6 class="aside-title">{{ $title }}</h6>
            </div>
            @if (count($compare) ==0)
                <div class="col-md-12 text-danger min-height-37vh">
                    {{ trans('front.no_data') }}
                </div>
            @else

            <div class="col-12">
                <div class="table-responsive">
                    <table class="table box table-bordered">
                        <tbody>
                            <tr>
                                @php
                                    $n = 0;
                                @endphp

                                @foreach($compare as $key => $item)
                                        @php
                                            $n++;
                                            $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                                        @endphp
                                        <td align="center">
                                            {{ $product->name }}({{ $product->sku }})
                                            <hr>
                                            <a href="{{ $product->getUrl() }}"><img width="100"
                                                    src="{{asset($product->getImage())}}" alt=""></a>
                                            <hr>
                                            {!! $product->showPrice() !!}
                                            <hr>
                                            {!! $product->description !!}
                                            <hr>
                                            <a onClick="return confirm('Confirm')" title="Remove Item" alt="Remove Item"
                                                class="cart_quantity_delete"
                                                href="{{ sc_route("cart.remove",['id'=>$item->rowId, 'instance' => 'compare']) }}"><i
                                                    class="fa fa-times"></i></a>
                                        </td>
                                        @if ($n % 4 == 0)
                                        </tr>
                                        @endif
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @endif
            
        </div>
    </div>
</div>

{{-- Render block include view --}}
@if ($includePathView = config('sc_include_view.shop_compare', []))
@foreach ($includePathView as $view)
  @if (view()->exists($view))
    @include($view)
  @endif
@endforeach
@endif
{{--// Render block include view --}}

@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}

@push('scripts')

  {{-- Render block include script --}}
  @if ($includePathScript = config('sc_include_script.shop_compare', []))
  @foreach ($includePathScript as $script)
    @if (view()->exists($script))
      @include($script)
    @endif
  @endforeach
  @endif
  {{--// Render block include script --}}

@endpush

@push('styles')
{{-- Your css style --}}
@endpush