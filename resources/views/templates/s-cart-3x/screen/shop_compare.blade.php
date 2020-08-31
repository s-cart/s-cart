@php
/*
$layout_page = shop_compare
$compare: no paginate
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
                                $product = (new App\Models\ShopProduct)->getDetail($item->id);
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
                                        href="{{ sc_route("compare.remove",['id'=>$item->rowId]) }}"><i
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
