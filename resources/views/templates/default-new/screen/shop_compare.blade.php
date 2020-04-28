@php
/*
$layout_page = shop_compare
$compare: no paginate
*/
@endphp

@extends($templatePath.'.layout')

@section('main')
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title-page">{{ $title }}</h2>
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
                                        href="{{route("compare.remove",['id'=>$item->rowId])}}"><i
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
</section>
@endsection

@section('breadcrumb')
<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
    </ol>
</div>
@endsection

@push('scripts')
@endpush
