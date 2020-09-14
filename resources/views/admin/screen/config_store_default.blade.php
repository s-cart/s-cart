@extends('admin.layout')
@section('main')
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab-store-order-tab" data-toggle="pill" href="#tab-store-order" role="tab" aria-controls="tab-store-order" aria-selected="false">{{ trans('store.admin.config_order') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-customer-tab" data-toggle="pill" href="#tab-store-customer" role="tab" aria-controls="tab-store-customer" aria-selected="false">{{ trans('store.admin.config_customer') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-product-tab" data-toggle="pill" href="#tab-store-product" role="tab" aria-controls="tab-store-product" aria-selected="false">{{ trans('store.admin.config_product') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-email-tab" data-toggle="pill" href="#tab-store-email" role="tab" aria-controls="tab-store-email" aria-selected="false">{{ trans('store.admin.config_email') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-url-tab" data-toggle="pill" href="#tab-store-url" role="tab" aria-controls="tab-store-url" aria-selected="false">{{ trans('store.admin.config_url') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-display-tab" data-toggle="pill" href="#tab-store-display" role="tab" aria-controls="tab-store-display" aria-selected="false">{{ trans('store.admin.config_display') }}</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            {{-- Tab order --}}
            <div class="tab-pane fade  fade active show" id="tab-store-order" role="tabpanel" aria-labelledby="store-order">
              @include('admin.screen.config_store.config_order')
            </div>
            {{-- //End tab order --}}

            {{-- Tab customer --}}
            <div class="tab-pane fade" id="tab-store-customer" role="tabpanel" aria-labelledby="tab-store-customer-tab">
              @include('admin.screen.config_store.config_customer')
            </div>
            {{-- //Tab customer --}}

            {{-- Tab product --}}
            <div class="tab-pane fade" id="tab-store-product" role="tabpanel" aria-labelledby="tab-store-product-tab">
              @include('admin.screen.config_store.config_product')
            </div>
            {{-- //Tab product --}}

            {{-- Tab email config --}}
            <div class="tab-pane fade" id="tab-store-email" role="tabpanel" aria-labelledby="tab-store-email-tab">
              @include('admin.screen.config_store.config_mail')
            </div>
            {{-- // Email config --}}


            {{-- Tab url config --}}
            <div class="tab-pane fade" id="tab-store-url" role="tabpanel" aria-labelledby="tab-store-url-tab">
              @include('admin.screen.config_store.config_url')
            </div>
            {{-- // Url config --}}

            {{-- Tab display config --}}
            <div class="tab-pane fade" id="tab-store-display" role="tabpanel" aria-labelledby="tab-store-display-tab">
              @include('admin.screen.config_store.config_display')
            </div>
            {{-- // display config --}}


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
        params.storeId = "{{ $storeId }}";
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

    $('.editable').editable({
        validate: function(value) {
        },
        success: function(data) {
          console.log(data);
          if(data.error == 0){
            alertJs('success', '{{ trans('admin.msg_change_success') }}');
          } else {
            alertMsg('error', data.msg);
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


<script>
  // Update config
  $(function () {
    $('#tab-store-customer input, #tab-store-product input, #tab-store-email .input-info, #tab-store-order input').iCheck({
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
        data: {"name": name,"value":isChecked,"_token": "{{ csrf_token() }}", "storeId":"{{ $storeId }}" },
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

<script>
  // Update store_info

//Logo
  $('.logo').change(function() {
        $.ajax({
        url: '{{ route('admin_store.update') }}',
        type: 'POST',
        dataType: 'JSON',
        data: {"name": $(this).attr('name'),"value":$(this).val(),"_token": "{{ csrf_token() }}", "storeId": "{{ $storeId }}" },
      })
      .done(function(data) {
        if(data.error == 0){
          alertJs('success', '{{ trans('admin.msg_change_success') }}');
        } else {
          alertJs('error', data.msg);
        }
      });
  });
//End logo


  function deleteItem(id){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ trans('admin.store_confirm_delete') }} #'+id,
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
                  id:id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                  console.log(data);
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ trans('admin.warning') }}');
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      alertMsg('success', data.msg);
                      $.pjax.reload('#pjax-container');
                      resolve(data);
                    }

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
    }
  })
}
  //End update store_info
</script>

@endpush
@endif