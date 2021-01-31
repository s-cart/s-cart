@extends($templatePathAdmin.'layout')

@section('main')

<div class="row">

  <div class="col-md-12">

    <div class="card">
      <div class="card-header with-border">
        <h2 class="card-title">{{ $title_description??'' }}</h2>
      </div>

      <div class="card-body table-responsivep-0">
      <table class="table table-hover">
         <tbody>

            <tr>
                  <th width="40%">{{ trans($pathPlugin.'::lang.secrect_key') }}</th>
                  <td><a href="#" class="updateData_can_empty editable editable-click" data-name="GoogleCaptcha_secrect_key" data-type="text" data-pk="GoogleCaptcha_secrect_key" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-value="{{ (sc_admin_can_config()) ? sc_config('GoogleCaptcha_secrect_key'): 'hidden' }}" data-title="{{ trans($pathPlugin.'::lang.secrect_key') }}"></a></td>
            </tr>  

          <tr>
            <th width="40%">{{ trans($pathPlugin.'::lang.site_key') }}</th>
            <td><a href="#" class="updateData_can_empty editable editable-click" data-name="GoogleCaptcha_site_key" data-type="text" data-pk="GoogleCaptcha_site_key" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-value="{{ sc_config('GoogleCaptcha_site_key') }}" data-title="{{ trans($pathPlugin.'::lang.site_key') }}"></a></td>
          </tr>    
    </td>
  </tr>


    </tbody>
       </table>
      </div>
    </div>
  </div>

</div>


@endsection


@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
<style type="text/css">
  #maintain_content img{
    max-width: 100%;
  }
</style>
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
  // Editable
$(document).ready(function() {

      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };
        $('.fied-required').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  trans('admin.not_empty') }}';
            }
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ trans('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });

    $('.updateData_can_empty').editable({
        success: function(data) {
          console.log(data);
          if(data.error == 0){
            alertJs('success', '{{ trans('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });

});
</script>
@endpush
