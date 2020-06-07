@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
        <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class=""><a href="{{ route('admin_plugin', ['code' => strtolower($code)]) }}">{{ trans('plugin.local') }}</a></li>
          <li class="active"><a href="#">{{ trans('plugin.online') }}</a></li>
          <li>{!! trans('plugin.plugin_import') !!}</li>
          <li class="pull-right">{!! trans('plugin.plugin_more') !!}</li>
          <li class="pull-right" >
            <a>{{ trans('plugin.only_version_current') }}: <input  class="only_version" name="only_version" type="checkbox"  {{ $only_version? 'checked':'' }}></a>
          </li>
        </ul>
            <!-- /.box-header -->
          <section id="pjax-container" class="table-list">
            <div class="box-body table-responsive no-padding">
              <table id="plugin" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>{{ trans('plugin.image') }}</th>
                  <th>{{ trans('plugin.code') }}</th>
                  <th>{{ trans('plugin.name') }}</th>
                  <th>{{ trans('plugin.version') }}</th>
                  <th>{{ trans('plugin.compatible') }}</th>
                  <th>{{ trans('plugin.auth') }}</th>
                  <th>{{ trans('plugin.price') }}</th>
                  <th>{{ trans('plugin.rated') }}</th>
                  <th><i class="fa fa-download" aria-hidden="true"></i></th>
                  <th>{{ trans('plugin.date') }}</th>
                  <th>{{ trans('plugin.action') }}</th>
                </tr>
                </thead>
                <tbody>
                  @if (!$arrPluginLibrary)
                    <tr>
                      <td colspan="5" style="text-align: center;color: red;">
                        {{ trans('plugin.empty') }}
                      </td>
                    </tr>
                  @else
                    @foreach ($arrPluginLibrary as  $plugin)
  @php
    $scVersion = explode(',', $plugin['scart_version']);
    $scRenderVersion = implode(' ',array_map(
      function($version){
      return '<span title="SCart version '.$version.'" class="label label-primary">'.$version.'</span>';
      },$scVersion)
    );

    if (array_key_exists($plugin['key'], $arrPluginLocal)) 
    {
      $pluginAction = '<span class="btn btn-flat btn-default" type="button">'.trans('plugin.located').'</span>';
    } elseif(!in_array(config('scart.version'), $scVersion)) {
      $pluginAction = '';
    } else {
      if(($plugin['is_free'] || $plugin['price_final'] == 0)) {
        $pluginAction = '<span onClick="installPlugin($(this),\''.$plugin['key'].'\', \''.$plugin['file'].'\');" title="'.trans('plugin.install').'" type="button" class="btn btn-flat btn-success"><i class="fa fa-plus-circle"></i></span>';
      } else {
        $pluginAction = '';
      }
    }
@endphp
                      <tr>
                        <td>{!! sc_image_render($plugin['image'],'50px', '', $plugin['name']) !!}</td>
                        <td>{{ $plugin['key'] }}</td>
                        <td>{{ $plugin['name'] }} <span data-toggle="tooltip" title="{!! $plugin['description'] !!}"><i class="fa fa-info-circle" aria-hidden="true"></i></span></td>
                        <td>{{ $plugin['version']??'' }}</td>
                        <td><b>SC:</b> {!! $scRenderVersion !!}</td>
                        <td>{{ $plugin['username']??'' }}</td>
                        <td>
                          @if ($plugin['is_free'] || $plugin['price_final'] == 0)
                            <span class="label label-success">{{ trans('plugin.free') }}</span>
                          @else
                              @if ($plugin['price_final'] != $plugin['price'])
                                  <span class="sc-old-price">{{ number_format($plugin['price']) }}</span><br>
                                  <span class="sc-new-price">${{ number_format($plugin['price_final']) }}</span>
                              @else
                                <span class="sc-new-price">${{ number_format($plugin['price_final']) }}</span>
                              @endif
                          @endif
                        </td>
                        <td>
                          @php
                          $vote = $plugin['points'];
                          $vote_times = $plugin['times'];
                          $cal_vote = $vote_times?round($vote/$vote_times,1):0;
                          @endphp
                          <span title="{{ $cal_vote }}" style="color:#e66c16">
                            @for ($i = 1; $i <= $cal_vote; $i++) 
                            <i class="fa fa-star voted" aria-hidden="true"></i>
                            @endfor
                            @if ($cal_vote * $vote_times == $vote)
                               <i class="fa fa-star-o" aria-hidden="true"></i>
                            @else
                               <i class="fa fa-star-half-o voted" aria-hidden="true"></i>
                            @endif
                            @for ($k = 1; $k < (5-$cal_vote); $k++) 
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            @endfor
                         </span>
                         <span class="sum_vote">
                          ({{ $vote }}/{{ $vote_times }})
                        </span>

                        </td>
                        <td>{{ $plugin['download']??'' }}</td>
                        <td>{{ $plugin['date']??'' }}</td>
                        <td>
                          {!! $pluginAction ?? '' !!}
                          <a href="{{ $plugin['link'] }}" title="Link home">
                            <span class="btn btn-flat btn-default" type="button">
                              <i class="fa fa-chain-broken" aria-hidden="true"></i> {!! trans('template.link') !!}
                            </span>
                          </a>
                        </td>  
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <div class="box-footer clearfix">
              {!! $resultItems??'' !!}
              <ul class="pagination pagination-sm no-margin pull-right">
                <!-- Previous Page Link -->
                    @if ($dataApi['current_page'] > 1)
                    <li class="page-item"><a class="page-link pjax-container" href="{{ route('admin_plugin_online', ['code' => strtolower($code)]) }}?page={{ $dataApi['current_page'] - 1}}" rel="prev">«</a></li>
                    @endif
                    @for ($i = 1; $i < $dataApi['last_page']; $i++)
                        @if ( $dataApi['current_page'] == $i)
                        <li class="page-item active"><span class="page-link pjax-container">{{ $i }}</span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ route('admin_plugin_online', ['code' => strtolower($code)]) }}?page={{ $i }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    @if ($dataApi['current_page'] < $dataApi['last_page'])
                    <li class="page-item"><a class="page-link pjax-container" href="{{ route('admin_plugin_online', ['code' => strtolower($code)]) }}?page={{ $dataApi['current_page'] + 1}}" rel="next">»</a></li>

                    @endif
                </ul>
           </div>
          </section>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
@endsection

@push('scripts')
{{-- //Pjax --}}
<script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>


<script type="text/javascript">
  function installPlugin(obj,key, path) {
      $('#loading').show()
      obj.button('loading');
      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ route('admin_plugin_online.install') }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "key":key,
          "path":path,
          "code":"{{ $code }}"
        },
        success: function (response) {
          console.log(response);
              if(parseInt(response.error) ==0){
              location.reload();
              }else{
                Swal.fire(
                  response.msg,
                  'You clicked the button!',
                  'error'
                  )
              }
              $('#loading').hide();
              obj.button('reset');
        }
      });
  }

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
    // tag a
    $(function(){
     $(document).pjax('a.page-link', '#pjax-container')
    })

    $(document).on('ready pjax:end', function(event) {
      //
    })

    $('[data-toggle="tooltip"]').tooltip();
</script>

<script>
  $('.only_version').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
  }).on('ifChanged', function(e) {
  var isChecked = e.currentTarget.checked;
  isChecked = (isChecked == false)?0:1;
  if(isChecked) {
    var url = '{{ route('admin_plugin_online', ['code' => $code]) }}?only_version=1';
  } else {
    var url = '{{ route('admin_plugin_online', ['code' => $code]) }}';
  }
  window.location.href = url;
    });
</script>
@endpush
