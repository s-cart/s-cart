@extends($templatePathAdmin.'layout')

@section('main')
      <div class="card card-primary card-outline card-outline-tabs">

        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            {{-- Tab infomation --}}
              <div class="row">
                <div class="col-md-5">
                  <table class="table table-hover table-bordered">
                  <tbody>

                    <tr>
                      <td><i class="fas fa-university"></i> {{ trans($pathPlugin.'::Lang.info') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="BankTransfer_info" data-type="text" data-pk="" data-source="" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ trans($pathPlugin.'::Lang.info') }}" data-value="{{ sc_config_global('BankTransfer_info') }}" data-original-title="" title="">{{sc_config_global('BankTransfer_info') }}</a></td>
                    </tr>
          
                  </td>
                </tr>
              
                  </tbody>
                     </table>
                </div>
              </div>
            {{-- //End tab infomation --}}
          </div>
        </div>
        <!-- /.card -->
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

@if (empty($dataNotFound))
@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">

  // Editable
$(document).ready(function() {

      //  $.fn.editable.defaults.mode = 'inline';
      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };

      $('.editable-required').editable({
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

});
</script>


  <script type="text/javascript">

    {!! $script_sort??'' !!}

  </script>

{{-- //Pjax --}}
<script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

@endpush
@endif