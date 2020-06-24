@extends('admin.layout')

@section('main')

<div class="row">

  <div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('setting.admin.setting_website') }}</h3>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
       <table class="table table-hover">
         <thead>
           <tr>
             <th>{{ trans('env.field') }}</th>
             <th>{{ trans('env.value') }}</th>
           </tr>
         </thead>
         <tbody>

        <tr>
          <td>{{ trans('env.SITE_TIMEZONE') }}</td>
          <td><a href="#" class="fied-required editable editable-click" data-name="SITE_TIMEZONE" data-type="select" data-pk="" data-source="{{ json_encode($timezones) }}" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.SITE_TIMEZONE') }}" data-value="{{ sc_config('SITE_TIMEZONE') }}" data-original-title="" title=""></a></td>
        </tr>

        <tr>
          <td>{{ trans('env.SITE_LANGUAGE') }}</td>
          <td><a href="#" class="fied-required editable editable-click" data-name="SITE_LANGUAGE" data-type="select" data-pk="" data-source="{{ json_encode($languages) }}" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.SITE_LANGUAGE') }}" data-value="{{ sc_config('SITE_LANGUAGE') }}" data-original-title="" title=""></a></td>
        </tr>

        <tr>
          <td>{{ trans('env.SITE_CURRENCY') }}</td>
          <td><a href="#" class="fied-required editable editable-click" data-name="SITE_CURRENCY" data-type="select" data-pk="" data-source="{{ json_encode($currencies) }}" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.SITE_CURRENCY') }}" data-value="{{ sc_config('SITE_CURRENCY') }}" data-original-title="" title=""></a></td>
        </tr>

          <tr>
            <td>{{ trans('env.APP_DEBUG') }}</td>
            <td><a href="#" class="fied-required editable editable-click" data-name="APP_DEBUG" data-type="select" data-pk="" data-source="{{ json_encode(['off'=>'OFF','on'=>'ON']) }}" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.APP_DEBUG') }}" data-value="{{ sc_config('APP_DEBUG') }}" data-original-title="{{ trans('env.APP_DEBUG') }}" title=""></a></td>
          </tr>


          <tr>
            <td>{{ trans('env.ADMIN_LOG') }}</td>
            <td><a href="#" class="fied-required editable editable-click" data-name="ADMIN_LOG" data-type="select" data-pk="" data-source="{{ json_encode(['off'=>'OFF','on'=>'ON']) }}" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.ADMIN_LOG') }}" data-value="{{ sc_config('ADMIN_LOG') }}" data-original-title="{{ trans('env.ADMIN_LOG') }}" title=""></a></td>
          </tr>
          
          <tr>
            <td>{{ trans('env.ADMIN_NAME') }}</td>
            <td><a href="#" class="fied-required editable editable-click" data-name="ADMIN_NAME" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.ADMIN_NAME') }}" data-value="{{ sc_config('ADMIN_NAME') }}" data-original-title="" title=""></a></td>
          </tr>
          <tr>
            <td>{{ trans('env.ADMIN_TITLE') }}</td>
            <td><a href="#" class="fied-required editable editable-click" data-name="ADMIN_TITLE" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.ADMIN_TITLE') }}" data-value="{{ sc_config('ADMIN_TITLE') }}" data-original-title="" title=""></a></td>
          </tr>
          <tr>
            <td>{{ trans('env.ADMIN_LOGO') }}</td>
            <td><a href="#" class="fied-required editable editable-click" data-name="ADMIN_LOGO" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.ADMIN_LOGO') }}" data-value="{{ sc_config('ADMIN_LOGO') }}" data-original-title="" title=""></a></td>
          </tr>
          <tr>
            <td>{{ trans('env.ADMIN_LOGO_MINI') }}</td>
            <td><a href="#" class="updateInfo editable editable-click" data-name="ADMIN_LOGO_MINI" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.ADMIN_LOGO_MINI') }}" data-value="{{ sc_config('ADMIN_LOGO_MINI') }}" data-original-title="" title=""></a></td>
          </tr>
          <tr>
            <td>{{ trans('env.LOG_SLACK_WEBHOOK_URL') }}</td>
            <td><a href="#" class="updateInfo editable editable-click" data-name="LOG_SLACK_WEBHOOK_URL" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_setting.update') }}" data-title="{{ trans('env.LOG_SLACK_WEBHOOK_URL_help') }}" data-value="{{ sc_config('LOG_SLACK_WEBHOOK_URL') }}" data-original-title="" title=""></a></td>
          </tr>
          

         </tbody>
       </table>
      </div>
    </div>
  </div>




  <div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('setting.admin.setting_shop') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
       <table class="table table-hover">
         <thead>
           <tr>
             <th>{{ trans('setting.admin.field') }}</th>
             <th>{{ trans('setting.admin.value') }}</th>
           </tr>
         </thead>
         <tbody>
           @foreach ($configs['config'] as $config)
             <tr>
               <td>{{ sc_language_render($config->detail) }}</td>
               <td><input type="checkbox" name="{{ $config->key }}"  {{ $config->value?"checked":"" }}></td>
             </tr>
           @endforeach
         </tbody>
       </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ trans('setting.admin.setting_display') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div>

      <div class="box-body table-responsive no-padding box-primary">
       <table class="table table-hover">
         <thead>
           <tr>
             <th width="40%">{{ trans('setting.admin.field') }}</th>
             <th>{{ trans('setting.admin.value') }}</th>
           </tr>
         </thead>
         <tbody>
           @foreach ($configs['display'] as $config)
             <tr>
               <td>{{ sc_language_render($config->detail) }}</td>
               <td align="left"><a href="#" class="fied-required editable editable-click" data-name="{{ $config->key }}" data-type="number" data-pk="{{ $config->key }}" data-source="" data-url="{{ route('admin_setting.update') }}" data-title="{{ sc_language_render($config->detail) }}" data-value="{{ $config->value }}" data-original-title="" title="">{{ $config->value }}</a></td>
             </tr>
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

      //$.fn.editable.defaults.mode = 'inline';
      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };
        $('.updateInfo').editable({});
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

    {!! $script_sort??'' !!}

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
      alertMsg('success', '{{ trans('admin.confirm_delete_deleted_msg') }}', '{{ trans('admin.confirm_delete_deleted') }}',);
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
        url: '{{ route('admin_setting.update') }}',
        type: 'POST',
        dataType: 'JSON',
        data: {"name": name,"value":isChecked,"_token": "{{ csrf_token() }}",},
      })
      .done(function(data) {
        if(data.error == 0){
          alertJs('success', '{{ trans('admin.msg_change_success') }}');
        } else {
          alertJs('error', data.msg);
        }
      });

      });

  });
  //End update config
</script>
@endpush
