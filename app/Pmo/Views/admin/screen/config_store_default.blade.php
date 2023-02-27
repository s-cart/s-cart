@extends($templatePathAdmin.'layout')
@section('main')
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <li class="nav-item">
              <a class="nav-link active" id="tab-store-order-tab" data-toggle="pill" href="#tab-store-order" role="tab" aria-controls="tab-store-order" aria-selected="false">{{ sc_language_render('store.admin.config_order') }}</a>
            </li>
            @endif
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <li class="nav-item">
              <a class="nav-link" id="tab-store-customer-tab" data-toggle="pill" href="#tab-store-customer" role="tab" aria-controls="tab-store-customer" aria-selected="false">{{ sc_language_render('store.admin.config_customer') }}</a>
            </li>
            @endif
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <li class="nav-item">
              <a class="nav-link" id="tab-store-product-tab" data-toggle="pill" href="#tab-store-product" role="tab" aria-controls="tab-store-product" aria-selected="false">{{ sc_language_render('store.admin.config_product') }}</a>
            </li>
            @endif
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <li class="nav-item">
              <a class="nav-link" id="tab-store-email-tab" data-toggle="pill" href="#tab-store-email" role="tab" aria-controls="tab-store-email" aria-selected="false">{{ sc_language_render('store.admin.config_email') }}</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" id="tab-store-url-tab" data-toggle="pill" href="#tab-store-url" role="tab" aria-controls="tab-store-url" aria-selected="false">{{ sc_language_render('store.admin.config_url') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-captcha-tab" data-toggle="pill" href="#tab-store-captcha" role="tab" aria-controls="tab-store-captcha" aria-selected="false">{{ sc_language_render('admin.captcha.captcha_title') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-store-display-tab" data-toggle="pill" href="#tab-store-display" role="tab" aria-controls="tab-store-display" aria-selected="false">{{ sc_language_render('store.admin.config_display') }}</a>
            </li>

            @if (count($configLayout))
            <li class="nav-item">
              <a class="nav-link" id="tab-store-layout-tab" data-toggle="pill" href="#tab-store-layout" role="tab" aria-controls="tab-store-layout" aria-selected="false">{{ sc_language_render('store.admin.config_layout') }}</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" id="tab-admin-other-tab" data-toggle="pill" href="#tab-admin-other" role="tab" aria-controls="tab-admin-other" aria-selected="false">{{ sc_language_render('store.admin.config_admin_other') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab-admin-customize-tab" data-toggle="pill" href="#tab-admin-customize" role="tab" aria-controls="tab-admin-customize" aria-selected="false">{{ sc_language_render('store.admin.config_customize') }}</a>
            </li>
          </ul>
        </div>
        
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            {{-- Tab order --}}
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <div class="tab-pane fade  fade active show" id="tab-store-order" role="tabpanel" aria-labelledby="store-order">
              @include($templatePathAdmin.'screen.config_store.config_order')
            </div>
            @endif
            {{-- //End tab order --}}

            {{-- Tab customer --}}
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <div class="tab-pane fade" id="tab-store-customer" role="tabpanel" aria-labelledby="tab-store-customer-tab">
              @include($templatePathAdmin.'screen.config_store.config_customer')
            </div>
            @endif
            {{-- //Tab customer --}}

            {{-- Tab product --}}
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            <div class="tab-pane fade" id="tab-store-product" role="tabpanel" aria-labelledby="tab-store-product-tab">
              @include($templatePathAdmin.'screen.config_store.config_product')
            </div>
            @endif
            
            {{-- //Tab product --}}
            @if (admin()->user()->isAdministrator() ||  admin()->user()->isViewAll())
            {{-- Tab email config --}}
            <div class="tab-pane fade" id="tab-store-email" role="tabpanel" aria-labelledby="tab-store-email-tab">
              @include($templatePathAdmin.'screen.config_store.config_mail')
            </div>
            {{-- // Email config --}}
            @endif

            {{-- Tab url config --}}
            <div class="tab-pane fade" id="tab-store-url" role="tabpanel" aria-labelledby="tab-store-url-tab">
              @include($templatePathAdmin.'screen.config_store.config_url')
            </div>
            {{-- // Url config --}}

            {{-- Tab captcha config --}}
            <div class="tab-pane fade" id="tab-store-captcha" role="tabpanel" aria-labelledby="tab-store-captcha-tab">
              @include($templatePathAdmin.'screen.config_store.config_captcha')
            </div>
            {{-- // captcha config --}}

            @if (count($configLayout))
            {{-- Tab layout config --}}
            <div class="tab-pane fade" id="tab-store-layout" role="tabpanel" aria-labelledby="tab-store-layout-tab">
              @include($templatePathAdmin.'screen.config_store.config_layout')
            </div>
            {{-- // layout config --}}
            @endif

            {{-- Tab display config --}}
            <div class="tab-pane fade" id="tab-store-display" role="tabpanel" aria-labelledby="tab-store-display-tab">
              @include($templatePathAdmin.'screen.config_store.config_display')
            </div>
            {{-- // display config --}}

            {{-- Tab admin config --}}
            <div class="tab-pane fade" id="tab-admin-other" role="tabpanel" aria-labelledby="tab-admin-other-tab">
              @include($templatePathAdmin.'screen.config_store.config_admin_other')
            </div>
            {{-- // admin config --}}

            {{-- Tab admin config customize --}}
            <div class="tab-pane fade" id="tab-admin-customize" role="tabpanel" aria-labelledby="tab-admin-customize-tab">
              @include($templatePathAdmin.'screen.config_store.config_admin_customize')
            </div>
            {{-- // admin config customize --}}

          </div>
        </div>
        <!-- /.card -->
</div>

@endsection

@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
<style type="text/css">
  #maintain_content img{
    max-width: 100%;
  }
</style>
@endpush

@if (empty($dataNotFound))
@push('scripts')
<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>

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

    $('.editable').editable({
        validate: function(value) {
        },
        success: function(data) {
          console.log(data);
          if(data.error == 0){
            alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
          } else {
            alertMsg('error', data.msg);
          }
      }
    });

});


$('input.check-data-config').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
  }).on('ifChanged', function(e) {
  var isChecked = e.currentTarget.checked;
  isChecked = (isChecked == false)?0:1;
  var name = $(this).attr('name');
    $.ajax({
      url: '{{ $urlUpdateConfig }}',
      type: 'POST',
      dataType: 'JSON',
      data: {
          "_token": "{{ csrf_token() }}",
          "name": $(this).attr('name'),
          "storeId": $(this).data('store'),
          "value": isChecked
        },
    })
    .done(function(data) {
      if(data.error == 0){
        alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
      } else {
        alertJs('error', data.msg);
      }
    });

    });

  $('input.check-data-config-global').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
  }).on('ifChanged', function(e) {
  var isChecked = e.currentTarget.checked;
  isChecked = (isChecked == false)?0:1;
  var name = $(this).attr('name');
    $.ajax({
      url: '{{ $urlUpdateConfigGlobal }}',
      type: 'POST',
      dataType: 'JSON',
      data: {
          "_token": "{{ csrf_token() }}",
          "name": $(this).attr('name'),
          "value": isChecked
        },
    })
    .done(function(data) {
      if(data.error == 0){
        if (isChecked == 0) {
          $('#smtp-config').hide();
        } else {
          $('#smtp-config').show();
        }
        alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
      } else {
        alertJs('error', data.msg);
      }
    });

    });


</script>

{{-- //Pjax --}}
<script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>


<script>
  // Update store_info

//End update store_info
</script>

@endpush
@endif