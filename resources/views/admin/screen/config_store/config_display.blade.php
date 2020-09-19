<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body table-responsivep-0">
       <table class="table table-hover">
         <tbody>
           @foreach ($configDisplay as $config)
             <tr>
               <td>{{ sc_language_render($config->detail) }}</td>
               <td align="left"><a href="#" class="editable-required editable editable-click" data-name="{{ $config->key }}" data-type="number" data-pk="{{ $config->key }}" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title="">{{ $config->value }}</a></td>
             </tr>
           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>
</div>