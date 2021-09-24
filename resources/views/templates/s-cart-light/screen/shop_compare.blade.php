@php
/*
$layout_page = shop_compare
**Variables:**
- $compare: no paginate
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main_content_center')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h6 class="aside-title">{{ $title }}</h6>
            </div>
            @if (count($compare) ==0)
                <div class="col-md-12 text-danger min-height-37vh">
                    {{ sc_language_render('front.data_notfound') }}
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
                                                    src="{{sc_file($product->getImage())}}" alt=""></a>
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
                                        @if ($n % 4 == 0 || $n == count($compare))
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

@endsection



@push('scripts')
{{-- script here --}}
@endpush

@push('styles')
{{-- Your css style --}}
@endpush