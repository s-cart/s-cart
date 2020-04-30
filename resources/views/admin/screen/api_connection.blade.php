@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_api_connection.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-sm-2 col-form-label">{{ trans('api_connection.description') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="description" name="description" value="{!! old()?old('description'):$api_connection['description']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('description') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('apiconnection') ? ' has-error' : '' }}">
                                <label for="apiconnection" class="col-sm-2 col-form-label">{{ trans('api_connection.apiconnection') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="apiconnection" name="apiconnection" value="{!! old()?old('apiconnection'):$api_connection['apiconnection']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('apiconnection'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('apiconnection') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('apikey') ? ' has-error' : '' }}">
                                <label for="apikey" class="col-sm-2 col-form-label">{{ trans('api_connection.apikey') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input style="max-width: 300px;" type="text" id="apikey" name="apikey" value="{!! old()?old('apikey'):$api_connection['apikey']??'' !!}" class="form-control" placeholder="" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" id="refreshkey" type="button">
                                                <i class="fa fa-refresh fa-fw"></i>
                                            </button>
                                          </div>
                                    </div>
                                        @if ($errors->has('apikey'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('apikey') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div
                            class="form-group  kind kind0 kind1  {{ $errors->has('expire') ? ' has-error' : '' }}">
                            <label for="expire"
                                class="col-sm-2 col-form-label">{{ trans('api_connection.expire') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                    <input type="text" style="width: 100px;" id="expire" name="expire"
                                        value="{!!old('expire', $api_connection['expire'] ?? null)!!}"
                                        class="form-control input-sm expire date_time" placeholder="" />
                                </div>
                                @if ($errors->has('expire'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('expire') }}
                                </span>
                                @endif
                            </div>
                        </div>


                            <div class="form-group  ">
                                <label for="status" class="col-sm-2 col-form-label">{{ trans('api_connection.status') }}</label>
                                <div class="col-sm-8">
                                <input class="input" type="checkbox" name="status"  {{ old('status',(empty($api_connection['status'])?0:1))?'checked':''}}>

                                </div>
                            </div>


                    <!-- /.box-body -->

                    <div class="box-footer">
                            @csrf
                        <div class="col-md-2">
                        </div>

                        <div class="col-md-8">
                            <div class="btn-group pull-right">
                                <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                            </div>

                            <div class="btn-group pull-left">
                                <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-footer -->
                </form>
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

@endpush
