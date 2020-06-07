@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class=""><a href="{{ route('admin_template.index') }}">{{ trans('template.local') }}</a></li>
            <li class="active"><a href="#">{{ trans('template.online') }}</a></li>
            <li>{!! trans('template.template_import') !!}</li>
            <li class="pull-right">{!! trans('template.template_more') !!}</li>
            <li class="pull-right" >
              <a>{{ trans('template.only_version_current') }}: <input  class="only_version" name="only_version" type="checkbox"  {{ $only_version? 'checked':'' }}></a>
            </li>
          </ul>
            <!-- /.box-header -->
          <section id="pjax-container" class="table-list">
            <div class="box-body table-responsive no-padding">
              <table id="template" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>{{ trans('template.image') }}</th>
                  <th>{{ trans('template.code') }}</th>
                  <th>{{ trans('template.name') }}</th>
                  <th>{{ trans('template.version') }}</th>
                  <th>{{ trans('template.compatible') }}</th>
                  <th>{{ trans('template.auth') }}</th>
                  <th>{{ trans('template.image_demo') }}</th>
                  <th>{{ trans('template.price') }}</th>
                  <th>{{ trans('template.rated') }}</th>
                  <th><i class="fa fa-download" aria-hidden="true"></i></th>
                  <th>{{ trans('template.date') }}</th>
                  <th>{{ trans('template.action') }}</th>
                </tr>
                </thead>
                <tbody>
                  @if (!$arrTemplateLibrary)
                    <tr>
                      <td colspan="5" style="text-align: center;color: red;">
                        {{ trans('template.empty') }}
                      </td>
                    </tr>
                  @else
                    @foreach ($arrTemplateLibrary as  $template)
@php
  $scVersion = explode(',', $template['scart_version']);
  $scRenderVersion = implode(' ',array_map(
    function($version){
    return '<span title="SCart version '.$version.'" class="label label-primary">'.$version.'</span>';
    },$scVersion)
  );

  if (array_key_exists($template['key'], $arrTemplateLocal)) 
  {
    $templateAction = trans('template.located');
  } elseif(!in_array(config('scart.version'), $scVersion)) {
    $templateAction = '';
  } else {
    if(($template['is_free'] || $template['price_final'] == 0)) {
      $templateAction = '<span onClick="installTemplate($(this),\''.$template['key'].'\', \''.$template['file'].'\');" title="'.trans('template.install').'" type="button" class="btn btn-flat btn-success"><i class="fa fa-plus-circle"></i></span>';
    } else {
      $templateAction = '';
    }
  }
@endphp
                      <tr>
                        <td>{!! sc_image_render($template['image'],'50px', '', $template['name']) !!}</td>
                        <td>{{ $template['key'] }}</td>
                        <td>{{ $template['name'] }} <span data-toggle="tooltip" title="{!! $template['description'] !!}"><i class="fa fa-info-circle" aria-hidden="true"></i></span></td>
                        <td>{{ $template['version']??'' }}</td>
                        <td><b>SC:</b> {!! $scRenderVersion !!}</td>
                        <td>{{ $template['username']??'' }}</td>
                        <td onclick="imagedemo('{{ $template['image_demo']??'' }}')"><a>{{ trans('template.click_here') }}</a></td>
                        <td>
                          @if ($template['is_free'] || $template['price_final'] == 0)
                            <span class="label label-success">{{ trans('template.free') }}</span>
                          @else
                              @if ($template['price_final'] != $template['price'])
                                  <span class="sc-old-price">{{ number_format($template['price']) }}</span><br>
                                  <span class="sc-new-price">${{ number_format($template['price_final']) }}</span>
                              @else
                                <span class="sc-new-price">${{ number_format($template['price_final']) }}</span>
                              @endif
                          @endif
                        </td>
                        <td>
                          @php
                          $vote = $template['points'];
                          $vote_times = $template['times'];
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
                        <td>{{ $template['download']??'' }}</td>
                        <td>{{ $template['date']??'' }}</td>
                        <td>
                          {!! $templateAction ?? '' !!}
                          <a href="{{ $template['link'] }}" title="Link home">
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
                    <li class="page-item"><a class="page-link pjax-container" href="{{ route('admin_template_online') }}?page={{ $dataApi['current_page'] - 1}}" rel="prev">«</a></li>
                    @endif
                    @for ($i = 1; $i < $dataApi['last_page']; $i++)
                        @if ( $dataApi['current_page'] == $i)
                        <li class="page-item active"><span class="page-link pjax-container">{{ $i }}</span></li>
                        @else
                        <li class="page-item"><a class="page-link" href="{{ route('admin_template_online') }}?page={{ $i }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    @if ($dataApi['current_page'] < $dataApi['last_page'])
                    <li class="page-item"><a class="page-link pjax-container" href="{{ route('admin_template_online') }}?page={{ $dataApi['current_page'] + 1}}" rel="next">»</a></li>

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
  function installTemplate(obj,key, path) {
      $('#loading').show()
      obj.button('loading');
      $.ajax({
        type: 'POST',
        dataType:'json',
        url: '{{ route('admin_template_online.install') }}',
        data: {
          "_token": "{{ csrf_token() }}",
          "key":key,
          "path":path,
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

    function imagedemo(image) {
      Swal.fire({
        title: '{{  trans('template.image_demo') }}',
        text: '',
        imageUrl: image,
        imageWidth: 800,
        imageHeight: 800,
        imageAlt: 'Image demo',
      })
    }

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
    var url = '{{ route('admin_template_online.index') }}?only_version=1';
  } else {
    var url = '{{ route('admin_template_online.index') }}';
  }
  window.location.href = url;
    });
</script>

@endpush
