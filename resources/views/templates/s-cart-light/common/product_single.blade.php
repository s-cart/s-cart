<article class="product wow fadeInRight">
    <div class="product-body">
      <div class="product-figure">
          <a href="{{ $product->getUrl() }}">
          <img src="{{ sc_file($product->getThumb()) }}" alt="{{ $product->name }}"/>
          </a>
      </div>
      <h5 class="product-title"><a href="{{ $product->getUrl() }}">{{ $product->name }}</a></h5>
      
      @if (empty($hiddenStore))
      {!! $product->displayVendor() !!}
      @endif

      @if ($product->allowSale())
      <a onClick="addToCartAjax('{{ $product->id }}','default','{{ $product->store_id }}')" class="button button-secondary button-zakaria add-to-cart-list">
        <i class="fa fa-cart-plus"></i> {{sc_language_render('action.add_to_cart')}}</a>
      @endif

      {!! $product->showPrice() !!}
    </div>
    
    @if ($product->price != $product->getFinalPrice() && $product->kind !=SC_PRODUCT_GROUP)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/sale.png') }}" class="new" alt="" /></span>
    @elseif($product->kind == SC_PRODUCT_BUILD)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/bundle.png') }}" class="new" alt="" /></span>
    @elseif($product->kind == SC_PRODUCT_GROUP)
    <span><img class="product-badge new" src="{{ sc_file($sc_templateFile.'/images/home/group.png') }}" class="new" alt="" /></span>
    @endif
    <div class="product-button-wrap">
      <div class="product-button">
          <a class="button button-secondary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','wishlist','{{ $product->store_id }}')">
              <i class="fas fa-heart"></i>
          </a>
      </div>
      <div class="product-button">
          <a class="button button-primary button-zakaria" onClick="addToCartAjax('{{ $product->id }}','compare','{{ $product->store_id }}')">
              <i class="fa fa-exchange"></i>
          </a>
      </div>
    </div>
</article>