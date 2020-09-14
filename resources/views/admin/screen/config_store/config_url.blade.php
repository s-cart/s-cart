<div class="card">
  <div class="card-body table-responsive">
   <table class="table table-hover">
     <tbody>

      <tr>
        <td>{{ trans('env.SUFFIX_URL') }}</td>
        <td><a href="#" class="updateInfo editable editable-click" data-name="SUFFIX_URL" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.SUFFIX_URL') }}" data-value="{{ sc_config('SUFFIX_URL') }}" data-original-title="" title=""></a></td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_SHOP') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_SHOP" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_SHOP') }}" data-value="{{ sc_config('PREFIX_SHOP') }}" data-original-title="" title=""></a></td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_PRODUCT') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_PRODUCT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_PRODUCT') }}" data-value="{{ sc_config('PREFIX_PRODUCT') }}" data-original-title="" title=""></a>/name-of-product{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_CATEGORY') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CATEGORY') }}" data-value="{{ sc_config('PREFIX_CATEGORY') }}" data-original-title="" title=""></a>/name-of-category{{ sc_config('SUFFIX_URL') }}</td>
      </tr>
      
      <tr>
        <td>{{ trans('env.PREFIX_BRAND') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_BRAND" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_BRAND') }}" data-value="{{ sc_config('PREFIX_BRAND') }}" data-original-title="" title=""></a>/name-of-brand{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_SUPPLIER') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_SUPPLIER" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_SUPPLIER') }}" data-value="{{ sc_config('PREFIX_SUPPLIER') }}" data-original-title="" title=""></a>/name-of-supplier{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_SEARCH') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_SEARCH" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_SEARCH') }}" data-value="{{ sc_config('PREFIX_SEARCH') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_CONTACT') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CONTACT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CONTACT') }}" data-value="{{ sc_config('PREFIX_CONTACT') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_NEWS') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_NEWS" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_NEWS') }}" data-value="{{ sc_config('PREFIX_NEWS') }}" data-original-title="" title=""></a>/name-of-blog-news{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_MEMBER') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER') }}" data-value="{{ sc_config('PREFIX_MEMBER') }}" data-original-title="" title=""></a>/page-name-member{{ sc_config('SUFFIX_URL') }}</td>
      </tr>         

      <tr>
        <td>{{ trans('env.PREFIX_MEMBER_ORDER_LIST') }}</td>
        <td>https://your-domain.com/{{ sc_config('PREFIX_MEMBER') }}/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER_ORDER_LIST" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER_ORDER_LIST') }}" data-value="{{ sc_config('PREFIX_MEMBER_ORDER_LIST') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>    

      <tr>
        <td>{{ trans('env.PREFIX_MEMBER_CHANGE_PWD') }}</td>
        <td>https://your-domain.com/{{ sc_config('PREFIX_MEMBER') }}/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER_CHANGE_PWD" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER_CHANGE_PWD') }}" data-value="{{ sc_config('PREFIX_MEMBER_CHANGE_PWD') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_MEMBER_CHANGE_INFO') }}</td>
        <td>https://your-domain.com/{{ sc_config('PREFIX_MEMBER') }}/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER_CHANGE_INFO" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER_CHANGE_INFO') }}" data-value="{{ sc_config('PREFIX_MEMBER_CHANGE_INFO') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_CMS_CATEGORY') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CMS_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CMS_CATEGORY') }}" data-value="{{ sc_config('PREFIX_CMS_CATEGORY') }}" data-original-title="" title=""></a>/name-of-cms-categoyr{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_CMS_ENTRY') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CMS_ENTRY" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CMS_ENTRY') }}" data-value="{{ sc_config('PREFIX_CMS_ENTRY') }}" data-original-title="" title=""></a>/name-of-entry-cms{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_CART_WISHLIST') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_WISHLIST" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_WISHLIST') }}" data-value="{{ sc_config('PREFIX_CART_WISHLIST') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>

      <tr>
        <td>{{ trans('env.PREFIX_CART_COMPARE') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_COMPARE" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_COMPARE') }}" data-value="{{ sc_config('PREFIX_CART_COMPARE') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr>          

      <tr>
        <td>{{ trans('env.PREFIX_CART_DEFAULT') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_DEFAULT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_DEFAULT') }}" data-value="{{ sc_config('PREFIX_CART_DEFAULT') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr> 

      <tr>
        <td>{{ trans('env.PREFIX_CART_CHECKOUT') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_CHECKOUT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_CHECKOUT') }}" data-value="{{ sc_config('PREFIX_CART_CHECKOUT') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr> 

      <tr>
        <td>{{ trans('env.PREFIX_ORDER_SUCCESS') }}</td>
        <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_ORDER_SUCCESS" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_ORDER_SUCCESS') }}" data-value="{{ sc_config('PREFIX_ORDER_SUCCESS') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
      </tr> 

     </tbody>
   </table>
  </div>
</div>