@extends('admin.layout')

@section('main')
@php
    $id = empty($id) ? 0 : $id;
@endphp
<div class="row">

    <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">{!! $title_action !!}</h3>
            @if ($layout == 'edit')
            <div class="btn-group float-right" style="margin-right: 5px">
                <a href="{{ route('admin_api_connection.index') }}" class="btn btn-flat btn-default" title="List"><i class="fa fa-list"></i>
                  <span class="hidden-xs"> {{trans('admin.back_list')}}</span>
                </a>
            </div>
          @endif
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main">
            <div class="card-body">
    
              <div class="form-group row {{ $errors->has('description') ? ' text-red' : '' }}">
                <label for="description" class="col-sm-2 col-form-label">{{ trans('api_connection.description') }}</label>
                <div class="col-sm-10 ">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                    <input type="text" id="description" name="description" value="{!! old()?old('description'):$api_connection['description']??'' !!}" class="form-control description {{ $errors->has('description') ? ' is-invalid' : '' }}">
                  </div>
    
                  @if ($errors->has('description'))
                  <span class="text-sm">
                    <i class="fa fa-info-circle"></i> {{ $errors->first('description') }}
                  </span>
                  @endif
                </div>
              </div>
        
              <div class="form-group row {{ $errors->has('apiconnection') ? ' text-red' : '' }}">
                <label for="apiconnection" class="col-sm-2 col-form-label">{{ trans('api_connection.apiconnection') }}</label>
                <div class="col-sm-10 ">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                    <input type="text" id="apiconnection" name="apiconnection" value="{!! old()?old('apiconnection'):$api_connection['apiconnection']??'' !!}" class="form-control apiconnection {{ $errors->has('apiconnection') ? ' is-invalid' : '' }}">
                  </div>
    
                  @if ($errors->has('apiconnection'))
                  <span class="text-sm">
                    <i class="fa fa-info-circle"></i> {{ $errors->first('apiconnection') }}
                  </span>
                  @endif
    
                </div>
              </div>

              <div class="form-group row {{ $errors->has('apikey') ? ' text-red' : '' }}">
                <label for="apikey" class="col-sm-2 col-form-label">{{ trans('api_connection.apikey') }}</label>
                <div class="col-sm-10 ">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                    <input type="text" id="apikey" name="apikey" value="{!! old()?old('apikey'):$api_connection['apikey']??'' !!}" class="form-control apikey {{ $errors->has('apikey') ? ' is-invalid' : '' }}">
                    <div class="input-group-append">
                        <button class="btn btn-default" id="refreshkey" type="button">
                            <i class="fas fa-sync-alt fa-fw"></i>
                        </button>
                      </div>
                  </div>
    
                  @if ($errors->has('apikey'))
                  <span class="text-sm">
                    <i class="fa fa-info-circle"></i> {{ $errors->first('apikey') }}
                  </span>
                  @endif
    
                </div>
              </div>

              <div class="form-group row {{ $errors->has('expire') ? ' text-red' : '' }}">
                <label for="expire" class="col-sm-2 col-form-label">{{ trans('api_connection.expire') }}</label>
                <div class="col-sm-10 ">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>
                    </div>
                    <input type="text" id="expire" name="expire" value="{!! old()?old('expire'):$api_connection['expire']??'' !!}" class="form-control expire date_time {{ $errors->has('expire') ? ' is-invalid' : '' }}">
                  </div>
    
                  @if ($errors->has('expire'))
                  <span class="text-sm">
                    <i class="fa fa-info-circle"></i> {{ $errors->first('expire') }}
                  </span>
                  @endif
    
                </div>
              </div>

              <div class="form-group row {{ $errors->has('status') ? ' text-red' : '' }}">
                <label for="status" class="col-sm-2 col-form-label">{{ trans('api_connection.status') }}</label>
                <div class="col-sm-10 ">
                  <div class="input-group mb-3">
                    <input class="input" type="checkbox" name="status"  {{ old('status',(empty($api_connection['status'])?0:1))?'checked':''}}>
                </div>
                  @if ($errors->has('status'))
                  <span class="text-sm">
                    <i class="fa fa-info-circle"></i> {{ $errors->first('status') }}
                  </span>
                  @endif

                </div>
              </div>

            </div>
            <!-- /.card-body -->
            @csrf
            <div class="card-footer row">
              <div class="col-md-12">
              <div class=" float-left">
              <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
              </div>
              <div class=" float-right">
              <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
              </div>
              </div>
            </div>
            <!-- /.card-footer -->
          </form>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-body p-0">   
            <div class="row">
                <div class="col-md-12 m-2">
                    {!! $rightContentMain !!}
                </div>
            </div>
        </div>
        </div>
      </div>
</div>

   <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header with-border">
            <h3 class="card-title">{!! $title ?? '' !!}</h3>
          </div>
    
          <div class="box-body table-responsive">
            <section id="pjax-container" class="table-list">
                <div class="card-body table-responsivep-0" >
                   <table class="table table-hover">
                      <thead>
                         <tr>
                          @if (!empty($removeList))
                          <th></th>
                          @endif
                          @foreach ($listTh as $key => $th)
                              <th>{!! $th !!}</th>
                          @endforeach
                         </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataTr as $keyRow => $tr)
                              <tr  class="{{ ($tr['id'] == $id)? 'active':$id }}">
                                  @if (!empty($removeList))
                                  <td>
                                    <input class="input" type="checkbox" class="grid-row-checkbox" data-id="{{ $tr['id']??'' }}">
                                  </td>
                                  @endif
                                  @foreach ($tr as $key => $trtd)
                                      <td>{!! $trtd !!}</td>
                                  @endforeach
                              </tr>
                          @endforeach
                      </tbody>
                   </table>
                </div>
                <div class="block-pagination clearfix m-10">
                    <div class="ml-3 float-left">
                      {!! $resultItems??'' !!}
                    </div>
                    <div class="pagination pagination-sm mr-3 float-right">
                      {!! $pagination??'' !!}
                    </div>
                  </div>
               </section>
        </div>
      </div>
      </div>
    </div>


@endsection

@push('styles')

@endpush

@push('scripts')
<script type="text/javascript">
//Date picker
$('.date_time').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

$(document).ready(function() {
    $('#refreshkey').click(function(){
        $('#loading').show();
        $.ajax({
            method: 'get',
            url: '{{ route('admin_api_connection.generate_key') }}',
            success: function (data) {
                $('#apikey').val(data.data);
                $('#loading').hide();
            }
        });
    });
    $('.select2').select2()
});
</script>

{!! $js ?? '' !!}

@endpush
