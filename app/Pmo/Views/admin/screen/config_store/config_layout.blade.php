{{-- Use sc_config with storeId, dont use sc_config_admin because will switch the store to the specified store Id
--}}

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body table-responsivep-0">
       <table class="table table-hover box-body text-wrap table-bordered">
        <tr>
          <th>{{ sc_language_quickly('admin.admin_custom_config.add_new_detail', 'Key detail') }}</th>
          <th>{{ sc_language_quickly('admin.admin_custom_config.add_new_value', 'Value') }}</th>
        </tr>
         <tbody>
           @foreach ($configLayout as $config)
           <tr>
            <td>{{ sc_language_render($config->detail) }}</td>
            <td><input class="check-data-config" data-store="{{ $storeId }}" type="checkbox" name="{{ $config->key }}"  {{ $config->value ? "checked":"" }}></td>
          </tr>
           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>
</div>