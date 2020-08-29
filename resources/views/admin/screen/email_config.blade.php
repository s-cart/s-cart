@extends('admin.layout')

@section('main')

<div class="row">

  <div class="col-md-6">

    <div class="card">
      <div class="card-header with-border">
        <h3 class="card-title">{{ trans('email.admin.config_mode') }}</h3>
      </div>

      <div class="card-body table-responsivep-0">
         <table class="table table-hover">
           <thead>
             <tr>
               <th>{{ trans('email.admin.field') }}</th>
               <th>{{ trans('email.admin.value') }}</th>
             </tr>
           </thead>
           <tbody>
             @foreach ($configs['email_action'] as $config)
               <tr>
                 <td>{!! sc_language_render($config->detail) !!}</td>
                 <td><input type="checkbox" name="{{ $config->key }}"  {{ $config->value?"checked":"" }}></td>
               </tr>
             @endforeach
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
         <thead>
           <tr>
             <th width="40%">{{ trans('email.admin.field') }}</th>
             <th>{{ trans('email.admin.value') }}</th>
           </tr>
         </thead>
         <tbody>
           @foreach ($configs['smtp_config'] as $config)

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
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
  // Editable
$(document).ready(function() {

      $.fn.editable.defaults.mode = 'inline';
      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };

        $('.editable').editable({
          validate: function(value) {
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ trans('admin.msg_change_success') }}');
          } else {
            alertMsg('error', data.msg);
          }
      }
    });
});
</script>

    {{-- //Pjax --}}
   <script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

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

    {{ $script_sort??'' }}

    $(document).on('ready pjax:end', function(event) {
      $('.table-list input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    })

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
    title: '{{ trans('admin.confirm_delete') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ trans('admin.confirm_delete_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ trans('admin.confirm_delete_no') }}',
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
      alertMsg('success', '{{ trans('admin.confirm_delete_deleted_msg') }}', '{{ trans('admin.confirm_delete_deleted') }}');
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
<script>

  // Update config
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    }).on('ifChanged', function(e) {
    var isChecked = e.currentTarget.checked;
    isChecked = (isChecked == false)?0:1;
    var name = $(this).attr('name');
      $.ajax({
        url: '{{ route('admin_config.update') }}',
        type: 'POST',
        dataType: 'JSON',
        data: {"name": name,"value":isChecked,"_token": "{{ csrf_token() }}",},
      })
      .done(function(data) {
        if(data.error == 0){
          alertJs('success', '{{ trans('admin.msg_change_success') }}');
        } else {
          alertMsg('error', '', data.msg);
        }
      });

      });

  });
  //End update config
</script>
@endpush
