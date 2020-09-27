<div class="card">
  <div class="card-body table-responsive">
   <table class="table table-hover">
     <tbody>

      <tr>
        <td>{{ trans('env.ADMIN_NAME') }}</td>
        <td><a href="#" class="editable-required editable editable-click" data-name="ADMIN_NAME" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.ADMIN_NAME') }}" data-value="{{ sc_config('ADMIN_NAME') }}" data-original-title="" title=""></a></td>
      </tr>

      <tr>
        <td>{{ trans('env.ADMIN_TITLE') }}</td>
        <td><a href="#" class="editable-required editable editable-click" data-name="ADMIN_TITLE" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.ADMIN_TITLE') }}" data-value="{{ sc_config('ADMIN_TITLE') }}" data-original-title="" title=""></a></td>
      </tr>

      <tr>
        <td>{{ trans('env.ADMIN_LOGO') }}</td>
        <td><a href="#" class="editable-required editable editable-click" data-name="ADMIN_LOGO" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.ADMIN_LOGO') }}" data-value="{{ sc_config('ADMIN_LOGO') }}" data-original-title="" title=""></a></td>
      </tr>

     </tbody>
   </table>
  </div>
</div>