@extends('admin.layout')

@section('main')

<div class="row">
@php
  $infosDescription = $obj->descriptions;
@endphp
  <div class="col-md-12">
    <div class="card">

      <div class="card-header with-border">
        <div class="float-right">
        <h3><a href="{{ route('admin_maintain.edit') }}"><i class="fa fa-edit" aria-hidden="true"></i>{{ trans('admin.edit') }}</a></h3>
        </div>
        <div class="float-left">
          <input id="maintain_mode" data-on-text="{{ trans('admin.maintain_enable') }}" data-off-text="{{ trans('admin.maintain_disable') }}" type="checkbox"  {{ (sc_config('SITE_STATUS') == 'off'?'checked':'') }}>
          <br><span><i class="fa fa-info-circle"></i>{!! trans('admin.maintain_help') !!}</span>
        </div>
         
        <!-- /.card-tools -->
      </div>

      <div class="card-body table-responsivep-0">
        @foreach ($infosDescription as  $infoDescription)
              <div class="card-header with-border">
                <h3 class="card-title">{{ trans('store_info.maintain_content') }} {{ $languages[$infoDescription['lang']] }}</h3>
              </div>
              <div class="table-responsivep-0">
                {!! sc_html_render($infoDescription['maintain_content']) !!}
              </div>
        @endforeach
      </div>
    </div>
  </div>

</div>


@endsection


@push('styles')

@endpush

@push('scripts')

    {{-- //Pjax --}}
   <script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

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

    $(document).on('ready pjax:end', function(event) {
//
    })

  </script>
    {{-- //End pjax --}}
    <script type="text/javascript">
      $("#maintain_mode").bootstrapSwitch();
      $('#maintain_mode').on('switchChange.bootstrapSwitch', function (event, state) {
          var site_status;
          if (state == true) {
              site_status =  'off';
          } else {
              site_status = 'on';
          }
          $('#loading').show()
          $.ajax({
            type: 'POST',
            dataType:'json',
            url: "{{ route('admin_setting.update') }}",
            data: {
              "_token": "{{ csrf_token() }}",
              "name": "SITE_STATUS",
              "value": site_status
            },
            success: function (response) {
                console.log(response);
              if(parseInt(response.error) ==0){
                  alertMsg('success', response.msg);
              }else{
                  alertMsg('error', response.msg);
              }
              $('#loading').hide();
            }
          });
      }); 
  
  </script>

@endpush
