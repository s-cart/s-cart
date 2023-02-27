{{-- Use sc_config with storeId, dont use sc_config_admin because will switch the store to the specified store Id
--}}

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body table-responsivep-0">
       <table class="table table-hover box-body text-wrap table-bordered">
         <tbody>
           @foreach ($configCaptcha as $config)
           @if ($config->key == 'captcha_mode')
           <tr>
            <td>{{ sc_language_render($config->detail) }}</td>
            <td><input class="check-data-config" data-store="{{ $storeId }}" type="checkbox" name="{{ $config->key }}"  {{ $config->value ? "checked":"" }}></td>
          </tr>
           @elseif($config->key == 'captcha_page')
           <tr>
            <td>{{ sc_language_render('admin.captcha.captcha_page_help') }}</td>
            <td align="left"><a href="#" class="editable-required editable editable-click" data-name="{{ $config->key }}" data-type="checklist" data-pk="{{ $config->key }}" data-source="{{ json_encode($captcha_page) }}" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title=""></a></td>
          </tr>
           @elseif($config->key == 'captcha_method')
          <tr>
            <td>{{ sc_language_render($config->detail) }}</td>
            <td align="left"><a href="#" class="editable-required editable editable-click" data-name="{{ $config->key }}" data-type="select" data-pk="{{ $config->key }}" data-source="{{ json_encode($pluginCaptchaInstalled) }}" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title=""></a></td>
          </tr>
          @else
          <tr>
            <td>{{ sc_language_render($config->detail) }}</td>
            <td align="left"><a href="#" class="editable-required editable editable-click" data-name="{{ $config->key }}" data-type="text" data-pk="{{ $config->key }}" data-source="" data-url="{{ $urlUpdateConfig }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title=""></a></td>
          </tr>
           @endif

           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>
</div>