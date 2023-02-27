@extends($templatePathAdmin.'layout')

@section('main')

<div class="row">

  <div class="col-md-6">

    <div class="card">

      <div class="card-body table-responsivep-0">
       <table class="table table-hover box-body text-wrap table-bordered">
         <tbody>
          <tr>
            <td colspan="3">
              <button type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> {{ sc_language_render('admin.cache.cache_clear_processing')}}" class="btn btn-flat btn-success clear-cache" data-clear="cache_all">
                <i class="fas fa-sync-alt"></i> {{ sc_language_render('admin.cache.cache_clear_all') }}
              </button>
            </td>
            
          </tr>
          <tr>
            <td>{{ sc_language_render('admin.cache.cache_status') }}</td>
            <td>
              <a href="#" class="fied-required editable editable-click" data-name="cache_status" data-type="select" data-pk="" data-source="{{ json_encode(['1'=>'ON','0'=>'OFF']) }}" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ sc_language_render('admin.cache.cache_status') }}" data-value="{{ sc_config_admin('cache_status') }}" data-original-title="" title=""></a>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>{{ sc_language_render('admin.cache.cache_time') }}</td>
            <td>
              <a href="#" class="cache-time data-cache_time"  data-name="cache_time" data-type="text" data-pk="" data-url="{{ sc_route_admin('admin_config_global.update') }}" data-title="{{ sc_language_render('admin.cache.cache_time') }}">{{ sc_config_admin('cache_time') }}</a>
            </td>
            <td></td>
          </tr>
           @foreach ($configs as $config)
           @if (!in_array($config->key, ['cache_status', 'cache_time']))
           <tr>
            <td>{{ sc_language_render($config->detail) }}</td>
            <td><input class="check-data-config-global" type="checkbox" name="{{ $config->key }}"  {{ $config->value?"checked":"" }}></td>
            <td>
              <button type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> {{ sc_language_render('admin.cache.cache_clear')}}" class="btn btn-flat btn-warning clear-cache" data-clear="{{ $config->key }}">
                <i class="fas fa-sync-alt"></i> {{ sc_language_render('admin.cache.cache_clear') }}
              </button>      
            </td>
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
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>

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
                return '{{  sc_language_render('admin.not_empty') }}';
            }
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
          } else {
            alertJs('error', response.msg);
          }
      }
    });

    $('.cache-time').editable({
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
        if (parseInt(value) < 0) {
          return '{{  sc_language_render('admin.gt_numeric_0') }}';
        }
     },
  
      success: function(response, newValue) {
        if(response.error == 0){
          alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
        } else {
          alertJs('error', response.msg);
        }
    }
  });
  
});



$('.clear-cache').click(function() {
  $(this).button('loading');
  $.ajax({
    url: '{{ sc_route_admin('admin_cache_config.clear_cache') }}',
    type: 'POST',
    dataType: 'JSON',
    data: {
      action: $(this).data('clear'),
        _token: '{{ csrf_token() }}',
    },
  })
  .done(function(data) {
    var obj = 'data-clear="'+data.action+'"';
    $("["+obj+"]").button('reset');
    if( data.action == 'cache_all') {
      setTimeout(function () {
        $(".clear-cache").prop('disabled', true);
      }, 100);
    } else {
      setTimeout(function () {
        $("["+obj+"]").prop('disabled', true);
      }, 100);
    }

    
    if(data.error == 0){
      alertJs('success', '{{ sc_language_render('admin.cache.cache_clear_success') }}');
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

@endpush
