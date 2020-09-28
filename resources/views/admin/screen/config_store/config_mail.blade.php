
    <div class="row">

      <div class="col-md-6">
    
        <div class="card">
          <div class="card-header with-border">
            <h3 class="card-title">{{ trans('email.admin.config_mode') }}</h3>
          </div>
    
          <div class="card-body table-responsivep-0">
             <table class="table table-hover">
               <tbody>
                 @if (!empty($emailConfig['email_action']))
                 @foreach ($emailConfig['email_action'] as $config)
                 <tr>
                   <td>{!! sc_language_render($config->detail) !!}</td>
                   <td><input class="check-data-config" data-store="{{ $storeId }}"  type="checkbox" name="{{ $config->key }}"  {{ $config->value?"checked":"" }}></td>
                 </tr>
               @endforeach
                 @endif
                 <tr>
                  <td>{{ trans('email.email_action.forgot_password') }}</td>
                  <td><input class="check-data-config" data-store="{{ $storeId }}"  type="checkbox" checked disabled></td>
                </tr>
               </tbody>
               <tfoot>
                <tr>
                  <td colspan="2">{!! trans('email.admin.help_note') !!}</td>
                </tr>
              </tfoot>
             </table>
          </div>
        </div>
      </div>
    
    
      <div class="col-md-6">
    
        <div class="card">
          <div class="card-header with-border">
            <h3 class="card-title">{{ trans('email.admin.config_smtp') }}</h3>
          </div>
    
          <div class="card-body table-responsivep-0">
             <table class="table table-hover">
             <tbody>
               @if (!empty($emailConfig['smtp_config']))
               @foreach ($emailConfig['smtp_config'] as $config)
               @if($config->key == 'smtp_security')
                <tr>
                  <td>{{ sc_language_render($config->detail) }}</td>
                  <td><a href="#" class="editable editable-click" data-name="{{ $config->key }}" data-type="select" data-pk="" data-source="{{ json_encode($smtp_method) }}" data-url="{{ route('admin_config.update') }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title=""></a></td>
                </tr>             
               @elseif($config->key == 'smtp_port')
                 <tr>
                   <td>{{ sc_language_render($config->detail) }}</td>
                   <td align="left"><a href="#" class="editable editable-click" data-name="{{ $config->key }}" data-type="number" data-pk="{{ $config->key }}" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title=""></a></td>
                 </tr>
               @elseif($config->key == 'smtp_password' || $config->key == 'smtp_user')
                 <tr>
                   <td>{{ sc_language_render($config->detail) }}</td>
                   <td align="left"><a href="#" class="editable editable-click" data-name="{{ $config->key }}" data-type="password" data-pk="{{ $config->key }}" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ (sc_admin_can_config()) ? $config->value: 'hidden' }}" data-original-title="" title=""></a></td>
                 </tr>
              @else
                 <tr>
                   <td>{{ sc_language_render($config->detail) }}</td>
                   <td align="left"><a href="#" class="editable editable-click" data-name="{{ $config->key }}" data-type="text" data-pk="{{ $config->key }}" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title=""></a></td>
                 </tr>
               @endif
               @endforeach
               @endif
             </tbody>
             </table>
          </div>
        </div>
      </div>
    
    </div>
