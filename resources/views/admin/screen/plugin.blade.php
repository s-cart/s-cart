@extends('admin.layout')

@section('main')
   <div class="row">
    <div class="col-md-12">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" href="#"  aria-controls="custom-tabs-four-home" aria-selected="true">{{ trans('plugin.local') }}</a>
            </li>
            @if (config('scart.settings.api_plugin'))
            <li class="nav-item">
              <a class="nav-link" href="{{  route('admin_plugin_online', ['code' => strtolower($code)]) }}" >{{ trans('plugin.online') }}</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" target=_new  href="{{ route('admin_plugin.import') }}" ><span><i class="fas fa-save"></i> {{ trans('plugin.import_data', ['data' => 'plugin']) }}</span></a>
            </li>
            <li class="btn-group float-right m-2">
              {!! trans('plugin.plugin_more') !!}
            </li>
          </ul>
        </div>

        <div class="card-body" id="pjax-container">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            <table class="table table-hover text-nowrap table-bordered">
              <thead>
                <tr>
                  <th>{{ trans('plugin.image') }}</th>
                  <th>{{ trans('plugin.code') }}</th>
                  <th>{{ trans('plugin.name') }}</th>
                  <th>{{ trans('plugin.version') }}</th>
                  <th>{{ trans('plugin.auth') }}</th>
                  <th>{{ trans('plugin.link') }}</th>
                  <th>{{ trans('plugin.sort') }}</th>
                  <th>{{ trans('plugin.action') }}</th>
                </tr>
              </thead>
              <tbody>
                @if (!$plugins)
                  <tr>
                    <td colspan="8" style="text-align: center;color: red;">
                      {{ trans('plugin.empty') }}
                    </td>
                  </tr>
                @else
                @foreach ($plugins as $codePlugin => $pluginClassName)
                @php
                  $classConfig = $pluginClassName.'\\AppConfig';
                  $pluginClass = new $classConfig;
                  //Check Plugin installed
                  if(!array_key_exists($codePlugin, $pluginsInstalled->toArray())){
                    $pluginStatusTitle = trans('plugin.not_install');
                    $pluginAction = '<span onClick="installPlugin($(this),\''.$codePlugin.'\');" title="'.trans('plugin.install').'" type="button" class="btn btn-flat btn-success"><i class="fa fa-plus-circle"></i></span>';
                  }else{
                    //Check plugin enable
                    if($pluginsInstalled[$codePlugin]['value']){
                      $pluginStatusTitle = trans('plugin.actived');
                      $pluginAction ='<span onClick="disablePlugin($(this),\''.$codePlugin.'\');" title="'.trans('plugin.disable').'" type="button" class="btn btn-flat btn-warning btn-flat"><i class="fa fa-power-off"></i></span>&nbsp;';
                        if($pluginClass->config()){
                          $pluginAction .='<a href="'.url()->current().'?action=config&pluginKey='.$codePlugin.'"><span title="'.trans('plugin.config').'" class="btn btn-flat btn-primary"><i class="fas fa-cog"></i></span>&nbsp;</a>';
                        }
                        //You can not remove if plugin is default
                        if(!in_array($codePlugin, $arrDefault)) {
                          $pluginAction .='<span onClick="uninstallPlugin($(this),\''.$codePlugin.'\');" title="'.trans('plugin.remove').'" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>';
                        }
                    }else{
                      $pluginStatusTitle = trans('plugin.disabled');
                      $pluginAction = '<span onClick="enablePlugin($(this),\''.$codePlugin.'\');" title="'.trans('plugin.enable').'" type="button" class="btn btn-flat btn-primary"><i class="fa fa-paper-plane"></i></span>&nbsp;';
                        if($pluginClass->config()){
                          $pluginAction .='<a href="'.url()->current().'?action=config&pluginKey='.$codePlugin.'"><span title="'.trans('plugin.config').'" class="btn btn-flat btn-primary"><i class="fas fa-cog"></i></span>&nbsp;</a>';
                        }

                        //You can not remove if plugin is default
                        if(!in_array($codePlugin, $arrDefault)) {
                          $pluginAction .='<span onClick="uninstallPlugin($(this),\''.$codePlugin.'\');" title="'.trans('plugin.remove').'" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i></span>';
                        }
                    }
                  }
                @endphp
                  <tr>
                    <td>{!! sc_image_render($pluginClass->image,'50px', '', $pluginClass->title) !!}</td>
                    <td>{{ $codePlugin }}</td>
                    <td>{{ $pluginClass->title }}</td>
                    <td>{{ $pluginClass->version??'' }}</td>
                    <td>{{ $pluginClass->auth??'' }}</td>
                    <td><a href="{{ $pluginClass->link??'' }}" target=_new><i class="fa fa-link" aria-hidden="true"></i>Link</a></td>
                    <td>{{ $pluginsInstalled[$codePlugin]['sort']??'' }}</td>
                    <td>
                      {!! $pluginAction !!}
                    </td>
                  </tr>
                @endforeach
                @endif
              </tbody>
            </table>

          </div>
        </div>
        <!-- /.card -->
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
  function enablePlugin(obj,key) {
      $('#loading').show()
      obj.button('loading');
      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ route('admin_plugin.enable') }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "key":key,
          "code":"{{ $code }}"
        },
        success: function (response) {
          console.log(response);
              if(parseInt(response.error) ==0){
                  $.pjax.reload({container:'#pjax-container'});
                  alertMsg('success', '{{ trans('admin.msg_change_success') }}');
              }else{
                alertMsg('error', response.msg);
              }
              $('#loading').hide();
              obj.button('reset');
        }
      });

  }
  function disablePlugin(obj,key) {
      $('#loading').show()
      obj.button('loading');
      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ route('admin_plugin.disable') }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "key":key,
          "code":"{{ $code }}"
        },
        success: function (response) {
          console.log(response);
              if(parseInt(response.error) ==0){
                  $.pjax.reload({container:'#pjax-container'});
                  alertMsg('success', '{{ trans('admin.msg_change_success') }}');
              }else{
                alertMsg('error', response.msg);
              }
              $('#loading').hide();
              obj.button('reset');
        }
      });
  }
  function installPlugin(obj,key) {
      $('#loading').show()
      obj.button('loading');
      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ route('admin_plugin.install') }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "key":key,
          "code":"{{ $code }}"
        },
        success: function (response) {
          console.log(response);
              if(parseInt(response.error) ==0){
              location.reload();
              }else{
                alertMsg('error', response.msg);
              }
              $('#loading').hide();
              obj.button('reset');
        }
      });
  }
  function uninstallPlugin(obj,key) {

      Swal.fire({
        title: '{{ trans('admin.action_admin.are_you_sure') }}',
        text: '{{ trans('admin.action_admin.delete_warning') }}',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '{{ trans('admin.action_admin.confirm_yes') }}',
      }).then((result) => {
        if (result.value) {
            $('#loading').show()
            obj.button('loading');
            $.ajax({
              type: 'POST',
              dataType:'json',
              url: '{{ route('admin_plugin.uninstall') }}',
              data: {
                "_token": "{{ csrf_token() }}",
                "key":key,
                "code":"{{ $code }}"
              },
              success: function (response) {
                console.log(response);
              if(parseInt(response.error) ==0){
              location.reload();
              }else{
                alertMsg('error', response.msg);
              }
              $('#loading').hide();
              obj.button('reset');
              }
            });
        }
      })
  }

    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

</script>

@endpush
