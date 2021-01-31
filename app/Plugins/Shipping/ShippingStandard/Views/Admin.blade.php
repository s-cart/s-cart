@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
  <div class="col-md-12">
     <div class="box">
          <div class="box-header with-border">
              <h2 class="box-title">{{ $title_description??'' }}</h2>

              <div class="box-tools">
                  <div class="btn-group pull-right" style="margin-right: 5px">
                      <a href="{{ sc_route_admin('admin_plugin',['code'=>'Shipping']) }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                  </div>
              </div>
          </div>
            <!-- /.box-header -->
            <div class="box-body">
             <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width="40%">{{ trans($pathPlugin.'::lang.fee') }}</th>
                  <th width="40%">{{ trans($pathPlugin.'::lang.shipping_free') }}</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>
                        <a href="#" class="update-num" 
                        data-name="fee" 
                        data-type="text" 
                        data-pk="{{ $data['id'] }}" 
                        data-url="{{ sc_route('shippingstandard.updateConfig') }}" 
                        data-title="{{ trans($pathPlugin.'::lang.fee') }}">
                          {{ $data['fee'] }}
                        </a>
                    </td>
                      <td>
                            <a href="#" class="update-num" 
                            data-name="shipping_free" 
                            data-type="text" 
                            data-pk="{{ $data['id'] }}" 
                            data-url="{{ sc_route('shippingstandard.updateConfig') }}" 
                            data-title="{{ trans($pathPlugin.'::lang.shipping_free') }}">
                            {{ $data['shipping_free'] }}
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
     </div>
  </div>
</div>
@endsection

@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function() {

    $.fn.editable.defaults.params = function (params) {
      params._token = "{{ csrf_token() }}";
      return params;
    };

    $('.update-num').editable({
    ajaxOptions: {
    type: 'post',
    dataType: 'json'
    },
    validate: function(value) {
        if (value == '') {
            return '{{  trans('admin.not_empty') }}';
        }
        if (!$.isNumeric(value)) {
            return '{{  trans('admin.only_numeric') }}';
        }
    }
    });
});

</script>

@endpush
