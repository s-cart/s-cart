@extends($templatePathAdmin.'layout')

@section('main')

<div class="row">
  <div class="col-md-12">

    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">{{ sc_language_render('admin.config.setting_website') }}</h3>
      </div>

      <div class="card-body table-responsivep-0">
       <table class="table table-hover box-body text-wrap table-bordered">
         <tbody>
          <tr>
            <td>{{ sc_language_render('admin.config.LOG_SLACK_WEBHOOK_URL') }}</td>
            <td><a href="#" class="updateInfo editable editable-click" data-name="LOG_SLACK_WEBHOOK_URL" data-type="password" data-pk="" data-source="" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="" data-value="{{ (sc_admin_can_config()) ? sc_config_global('LOG_SLACK_WEBHOOK_URL') : 'hidden' }}" data-original-title="" title=""></a></td>
          </tr>
          <tr>
            <td>{{ sc_language_render('admin.config.GOOGLE_CHAT_WEBHOOK_URL') }}</td>
            <td><a href="#" class="updateInfo editable editable-click" data-name="GOOGLE_CHAT_WEBHOOK_URL" data-type="password" data-pk="" data-source="" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="" data-value="{{ (sc_admin_can_config()) ? sc_config_global('GOOGLE_CHAT_WEBHOOK_URL') : 'hidden' }}" data-original-title="" title=""></a></td>
          </tr>
          <tr>
            <td>{{ sc_language_render('admin.config.CHATWORK_CHAT_WEBHOOK_URL') }}</td>
            <td><a href="#" class="updateInfo editable editable-click" data-name="CHATWORK_CHAT_WEBHOOK_URL" data-type="password" data-pk="" data-source="" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="" data-value="{{ (sc_admin_can_config()) ? sc_config_global('CHATWORK_CHAT_WEBHOOK_URL') : 'hidden' }}" data-original-title="" title=""></a></td>
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
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
  // Editable
$(document).ready(function() {

      //$.fn.editable.defaults.mode = 'inline';
      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };
        $('.updateInfo').editable({});
        $('.fied-required').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });
});
</script>

    {{-- //Pjax --}}
   <script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

    $('.grid-refresh').click(function(){
      $.pjax.reload({container:'#pjax-container'});
    });

    $(document).on('pjax:send', function() {
      $('#loading').show()
    })
    $(document).on('pjax:complete', function() {
      $('#loading').hide()
    })
    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

    {!! $script_sort??'' !!}

  </script>
    {{-- //End pjax --}}


<script type="text/javascript">
{{-- sweetalert2 --}}
var selectedRows = function () {
    var selected = [];
    $('.grid-row-checkbox:checked').each(function(){
        selected.push($(this).data('id'));
    });

    return selected;
}

$('.grid-trash').on('click', function() {
  var ids = selectedRows().join();
  deleteItem(ids);
});

  function deleteItem(ids){
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  })

  swalWithBootstrapButtons.fire({
    title: '{{ sc_language_render('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ $urlDeleteItem ?? '' }}',
                data: {
                  ids:ids,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    $.pjax.reload('#pjax-container');
                    resolve(data);
                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}',);
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}
{{--/ sweetalert2 --}}

</script>
@endpush
