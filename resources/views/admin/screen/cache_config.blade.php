@extends('admin.layout')

@section('main')

<div class="row">

  <div class="col-md-6">

    <div class="card">

      <div class="card-body table-responsivep-0">
       <table class="table table-hover">
         <tbody>
          <tr>
            <td colspan="3">
              <button type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> {{ trans('cache.config_manager.cache_clear_processing')}}" class="btn btn-flat btn-success clear-cache" data-clear="cache_all">
                <i class="fas fa-sync-alt"></i> {{ trans('cache.config_manager.cache_clear_all') }}
              </button>
            </td>
            
          </tr>
          <tr>
            <td>{{ trans('cache.config_manager.cache_status') }}</td>
            <td>
              <a href="#" class="fied-required editable editable-click" data-name="cache_status" data-type="select" data-pk="" data-source="{{ json_encode(['1'=>'ON','0'=>'OFF']) }}" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('cache.config_manager.cache_status') }}" data-value="{{ sc_config('cache_status') }}" data-original-title="" title=""></a>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>{{ trans('cache.config_manager.cache_time') }}</td>
            <td>
              <a href="#" class="cache-time data-cache_time"  data-name="cache_time" data-type="text" data-pk="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('cache.config_manager.cache_time') }}">{{ sc_config('cache_time') }}</a>
            </td>
            <td></td>
          </tr>
           @foreach ($configs as $config)
           @if (!in_array($config->key, ['cache_status', 'cache_time']))
           <tr>
            <td>{{ sc_language_render($config->detail) }}</td>
            <td><input type="checkbox" name="{{ $config->key }}"  {{ $config->value?"checked":"" }}></td>
            <td>
              <button type="button" data-loading-text="<i class='fa fa-spinner fa-spin'></i> {{ trans('cache.config_manager.cache_clear')}}" class="btn btn-flat btn-warning clear-cache" data-clear="{{ $config->key }}">
                <i class="fas fa-sync-alt"></i> {{ trans('cache.config_manager.cache_clear') }}
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
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
  // Editable
$(document).ready(function() {

       {{-- $.fn.editable.defaults.mode = 'inline'; --}}
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
            return '{{  trans('admin.not_empty') }}';
        }
        if (!$.isNumeric(value)) {
            return '{{  trans('admin.only_numeric') }}';
        }
        if (parseInt(value) < 0) {
          return '{{  trans('admin.gt_numeric_0') }}';
        }
     },
  
      success: function(response, newValue) {
        if(response.error == 0){
          alertJs('success', '{{ trans('admin.msg_change_success') }}');
        } else {
          alertJs('error', response.msg);
        }
    }
  });
  

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
            alertJs('error', data.msg);
          }
        });
  
        });
  
    });
  
});



$('.clear-cache').click(function() {
  $(this).button('loading');
  $.ajax({
    url: '{{ route('admin_cache_config.clear_cache') }}',
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
      alertJs('success', '{{ trans('cache.config_manager.cache_clear_success') }}');
    } else {
      alertJs('error', data.msg);
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
    $(document).ready(function() {
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

</script>

@endpush
