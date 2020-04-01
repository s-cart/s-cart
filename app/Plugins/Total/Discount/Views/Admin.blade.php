@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_discount.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('code') ? ' has-error' : '' }}">
                                <label for="code" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.code') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i></span>
                                        <input type="text" id="code" name="code" value="{{ old()?old('code'):$discount['code']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('code'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i>  {{ $errors->first('code') }}
                                            </span>
                                        @else
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i>  {{ trans('Plugins/Total/Discount::lang.admin.code_helper') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('reward') ? ' has-error' : '' }}">
                                <label for="reward" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.reward') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-file-text-o fa-fw"></i></span>
                                        <input type="text" id="reward" name="reward" value="{{ old()?old('reward'):$discount['reward']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('reward'))
                                            <span class="help-block">
                                                {{ $errors->first('reward') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group   {{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="type" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.type') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <label class="radio-inline"><input type="radio" name="type" value="point" {{ (old('type',$discount['type']??'') == 'point')?'checked':'' }}> Point</label>
                                    <label class="radio-inline"><input type="radio" name="type" value="percent" {{ (old('type',$discount['type']??'') == 'percent')?'checked':'' }}> Percent (%)</label>
                                    </div>
                                        @if ($errors->has('type'))
                                            <span class="help-block">
                                                {{ $errors->first('type') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group   {{ $errors->has('data') ? ' has-error' : '' }}">
                                <label for="data" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.data') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="data" name="data" value="{{ old()?old('data'):$discount['data']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('data'))
                                            <span class="help-block">
                                                {{ $errors->first('data') }}
                                            </span>
                                        @endif
                                </div>
                            </div>



                            <div class="form-group   {{ $errors->has('limit') ? ' has-error' : '' }}">
                                <label for="limit" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.limit') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="number" id="limit" name="limit" value="{{ old()?old('limit'):$discount['limit']??'1' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('limit'))
                                            <span class="help-block">
                                                {{ $errors->first('limit') }}
                                            </span>
                                        @endif
                                </div>
                            </div>



                            <div class="form-group   {{ $errors->has('login') ? ' has-error' : '' }}">
                                <label for="login" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.login') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="checkbox"  id="login" name="login" {{ old('login',(empty($discount['login'])?0:1))?'checked':''}}  placeholder="" class="check-form" />
                                    </div>
                                        @if ($errors->has('login'))
                                            <span class="help-block">
                                                {{ $errors->first('login') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                            <div class="form-group   {{ $errors->has('expires_at') ? ' has-error' : '' }}">
                                <label for="expires_at" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.expires_at') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                        <input type="text" id="expires_at" name="expires_at" value="{{ old()?old('expires_at'):$discount['expires_at']??'' }}" class="form-control date_time" style="width: 100px;" placeholder="" />
                                    </div>
                                        @if ($errors->has('expires_at'))
                                            <span class="help-block">
                                                {{ $errors->first('expires_at') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  ">
                                <label for="status" class="col-sm-2  control-label">{{ trans('Plugins/Total/Discount::lang.status') }}</label>
                                <div class="col-sm-8">
                                   <input class="input" type="checkbox" name="status"  {{ old('status',(empty($discount['status'])?0:1))?'checked':''}}>
                                </div>
                            </div>

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
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/select2/dist/css/select2.min.css')}}">

{{-- switch --}}
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-switch.min.css')}}">

@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('admin/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script>

{{-- switch --}}
<script src="{{ asset('admin/plugin/bootstrap-switch.min.js')}}"></script>



<script type="text/javascript">

$(document).ready(function() {
    $('.select2').select2()
});

//Date picker
$('.date_time').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd'
})
</script>
<script>
  $(function () {
    $('input.check-form').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
@endpush
