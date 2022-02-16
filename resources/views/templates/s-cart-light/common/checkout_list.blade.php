<div class="col-md-12">
  <div class="table-responsive">
      <table class="table box table-bordered">
          <thead>
              <tr style="background: #eaebec">
                  <th style="width: 50px;">No.</th>
                  <th>{{ sc_language_render('product.name') }}</th>
                  <th>{{ sc_language_render('product.price') }}</th>
                  <th>{{ sc_language_render('product.quantity') }}</th>
                  <th>{{ sc_language_render('product.subtotal') }}</th>
              </tr>
          </thead>
          <tbody>
              @foreach($cartItem as $item)
                  @php
                      $n = (isset($n)?$n:0);
                      $n++;
                      // Check product in cart
                      $product = $modelProduct->start()->getDetail($item->id, null, $item->storeId);
                      if(!$product) {
                          continue;
                      }
                      // End check product in cart
                  @endphp
              <tr class="row_cart form-group {{ session('arrErrorQty')[$product->id] ?? '' }}{{ (session('arrErrorQty')[$product->id] ?? 0) ? ' has-error' : '' }}">
                  <td>{{ $n }}</td>
                  <td>
                      <a href="{{$product->getUrl() }}" class="row_cart-name">
                          <img width="100" src="{{sc_file($product->getImage())}}"
                              alt="{{ $product->name }}">
                      </a>
                          <span>
                            <a href="{{$product->getUrl() }}" class="row_cart-name">{{ $product->name }}</a><br />
                              <b>{{ sc_language_render('product.sku') }}</b> : {{ $product->sku }}
                              {!! $product->displayVendor() !!}<br>
                              {{-- Process attributes --}}
                              @if ($item->options->count())
                              @foreach ($item->options as $groupAtt => $att)
                              <b>{{ $attributesGroup[$groupAtt] }}</b>: {!! sc_render_option_price($att) !!}
                              @endforeach
                              @endif
                              {{-- //end Process attributes --}}
                          </span>
                      </a>
                  </td>

                  <td>{!! $product->showPrice() !!}</td>

                  <td class="cart-col-qty">
                      <div class="cart-qty">
                        {{$item->qty}}
                      </div>
                  </td>

                  <td align="right">
                      {{sc_currency_render($item->subtotal)}}
                  </td>
              </tr>

              @endforeach
          </tbody>
      </table>
  </div>
</div>


@push('scripts')
@endpush