{{-- Use sc_config with storeId, dont use sc_config_admin because will switch the store to the specified store Id
--}}

<div class="card">
  <div class="card-body table-responsive">
   <table class="table table-hover box-body text-wrap table-bordered">
     <tbody>

      <tr>
        <td>{{ sc_language_render('admin.env.SUFFIX_URL') }}</td>
        <td><a href="#" class="updateInfo editable editable-click" data-name="SUFFIX_URL" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.SUFFIX_URL') }}" data-value="{{ sc_config('SUFFIX_URL', $storeId) }}" data-original-title="" title=""></a></td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_SHOP') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_SHOP" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_SHOP') }}" data-value="{{ sc_config('PREFIX_SHOP', $storeId) }}" data-original-title="" title=""></a></td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_PRODUCT') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_PRODUCT" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_PRODUCT') }}" data-value="{{ sc_config('PREFIX_PRODUCT', $storeId) }}" data-original-title="" title=""></a>/name-of-product{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CATEGORY') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CATEGORY') }}" data-value="{{ sc_config('PREFIX_CATEGORY', $storeId) }}" data-original-title="" title=""></a>/name-of-category{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>
      
      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_SUB_CATEGORY') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_SUB_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_SUB_CATEGORY') }}" data-value="{{ sc_config('PREFIX_SUB_CATEGORY', $storeId) }}" data-original-title="" title=""></a>/name-of-category{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_BRAND') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_BRAND" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_BRAND') }}" data-value="{{ sc_config('PREFIX_BRAND', $storeId) }}" data-original-title="" title=""></a>/name-of-brand{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_SEARCH') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_SEARCH" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_SEARCH') }}" data-value="{{ sc_config('PREFIX_SEARCH', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CONTACT') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CONTACT" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CONTACT') }}" data-value="{{ sc_config('PREFIX_CONTACT', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_ABOUT') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_ABOUT" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_ABOUT') }}" data-value="{{ sc_config('PREFIX_ABOUT', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_NEWS') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_NEWS" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_NEWS') }}" data-value="{{ sc_config('PREFIX_NEWS', $storeId) }}" data-original-title="" title=""></a>/name-of-blog-news{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_MEMBER') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_MEMBER" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_MEMBER') }}" data-value="{{ sc_config('PREFIX_MEMBER', $storeId) }}" data-original-title="" title=""></a>/page-name-member{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>         

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_MEMBER_ORDER_LIST') }}</td>
        <td>{{ url('/') }}/{{ sc_config('PREFIX_MEMBER', $storeId) }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_MEMBER_ORDER_LIST" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_MEMBER_ORDER_LIST') }}" data-value="{{ sc_config('PREFIX_MEMBER_ORDER_LIST', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>    

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_MEMBER_CHANGE_PWD') }}</td>
        <td>{{ url('/') }}/{{ sc_config('PREFIX_MEMBER', $storeId) }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_MEMBER_CHANGE_PWD" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_MEMBER_CHANGE_PWD') }}" data-value="{{ sc_config('PREFIX_MEMBER_CHANGE_PWD', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_MEMBER_CHANGE_INFO') }}</td>
        <td>{{ url('/') }}/{{ sc_config('PREFIX_MEMBER', $storeId) }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_MEMBER_CHANGE_INFO" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_MEMBER_CHANGE_INFO') }}" data-value="{{ sc_config('PREFIX_MEMBER_CHANGE_INFO', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CMS_CATEGORY') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CMS_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CMS_CATEGORY') }}" data-value="{{ sc_config('PREFIX_CMS_CATEGORY', $storeId) }}" data-original-title="" title=""></a>/name-of-cms-categoyr</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CART_WISHLIST') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CART_WISHLIST" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CART_WISHLIST') }}" data-value="{{ sc_config('PREFIX_CART_WISHLIST', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CART_COMPARE') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CART_COMPARE" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CART_COMPARE') }}" data-value="{{ sc_config('PREFIX_CART_COMPARE', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr>          

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CART_DEFAULT') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CART_DEFAULT" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CART_DEFAULT') }}" data-value="{{ sc_config('PREFIX_CART_DEFAULT', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr> 

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_CART_CHECKOUT') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_CART_CHECKOUT" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_CART_CHECKOUT') }}" data-value="{{ sc_config('PREFIX_CART_CHECKOUT', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr> 

      <tr>
        <td>{{ sc_language_render('admin.env.PREFIX_ORDER_SUCCESS') }}</td>
        <td>{{ url('/') }}/<a href="#" class="editable-required editable editable-click" data-name="PREFIX_ORDER_SUCCESS" data-type="text" data-pk="" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render('admin.env.PREFIX_ORDER_SUCCESS') }}" data-value="{{ sc_config('PREFIX_ORDER_SUCCESS', $storeId) }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL', $storeId) }}</td>
      </tr> 

     </tbody>
   </table>
  </div>
</div>