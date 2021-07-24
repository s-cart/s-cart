@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
  <div class="col-md-12">
     <div class="card">
          <div class="card-header with-border">
              <h2 class="card-title">{{ $title_description??'' }}</h2>

              <div class="card-tools">
                  <div class="btn-group pull-right" style="margin-right: 5px">
                      <a href="{{ sc_route_admin('admin_plugin',['code'=>'Shipping']) }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{sc_language_render('admin.back_list')}}</span></a>
                  </div>
              </div>
          </div>
            <!-- /.card-header -->
            <div class="card-body">
             <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th width="40%">{{ sc_language_render($pathPlugin.'::lang.fee') }}</th>
                  <th width="40%">{{ sc_language_render($pathPlugin.'::lang.shipping_free') }}</th>
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
                        data-title="{{ sc_language_render($pathPlugin.'::lang.fee') }}">
                          {{ $data['fee'] }}
                        </a>
                    </td>
                      <td>
                            <a href="#" class="update-num" 
                            data-name="shipping_free" 
                            data-type="text" 
                            data-pk="{{ $data['id'] }}" 
                            data-url="{{ sc_route('shippingstandard.updateConfig') }}" 
                            data-title="{{ sc_language_render($pathPlugin.'::lang.shipping_free') }}">
                            {{ $data['shipping_free'] }}
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
     </div>
  </div>
</div>
@endsection

@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>
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
            return '{{  sc_language_render('admin.not_empty') }}';
        }
        if (!$.isNumeric(value)) {
            return '{{  sc_language_render('admin.only_numeric') }}';
        }
    }
    });
});

</script>

@endpush
