<div class="row">

  <div class="col-md-5">
    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">{{ trans('product.admin.setting_info') }}</h3>
      </div>

      <div class="card-body table-responsivep-0">
       <table class="table table-hover">
         <tbody>
           @foreach ($productConfig as $config)
           @if ($config['key'] == 'product_tax')
           <tr>
            <td>{{ trans('product.config_manager.tax') }}</td>
            <td><a href="#" class="editable-required" data-name="product_tax" data-type="select" data-pk="" data-source="{{ json_encode($taxs) }}" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('product.config_manager.tax') }}" data-value="{{ sc_config('product_tax') }}" data-original-title="" title="" data-placement="left"></a></td>
          </tr>
           @else
           <tr>
            <td>{{ sc_language_render($config['detail']) }}</td>
            <td><input type="checkbox" name="{{ $config['key'] }}"  {{ $config['value']?"checked":"" }}></td>
          </tr>
           @endif

           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>

  <div class="col-md-7">
    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">{{ trans('product.admin.setting_info') }}</h3>
      </div>

      <div class="card-body table-responsivep-0">
       <table class="table table-hover">
        <thead>
          <tr>
            <th>{{ trans('product.config_manager.field') }}</th>
            <th>{{ trans('product.config_manager.value') }}</th>
            <th>{{ trans('product.config_manager.required') }}</th>
          </tr>
        </thead>
         <tbody>
           @foreach ($productConfigAttribute as $key => $config)
           <tr>
            <td>{{ sc_language_render($config['detail']) }}</td>
            <td><input type="checkbox" name="{{ $config['key'] }}"  {{ $config['value']?"checked":"" }}></td>
            <td>
              @if (!empty($productConfigAttributeRequired[$key.'_required']))
              <input type="checkbox" name="{{ $productConfigAttributeRequired[$key.'_required']['key'] }}"  {{ $productConfigAttributeRequired[$key.'_required']['value']?"checked":"" }}>
              @endif
            </td>
          </tr>
           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>

</div>