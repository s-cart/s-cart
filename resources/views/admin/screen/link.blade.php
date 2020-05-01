@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_link.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 col-form-label">{{ trans('link.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="name" name="name" value="{!! old()?old('name'):$link['name']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('url') ? ' has-error' : '' }}">
                                <label for="url" class="col-sm-2 col-form-label">{{ trans('link.url') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="url" name="url" value="{!! old()?old('url'):$link['url']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('url'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('url') }}
                                            </span>
                                        @else
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ trans('link.admin.helper_url') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group  {{ $errors->has('target') ? ' has-error' : '' }}">
                                <label for="target" class="col-sm-2 col-form-label">{{ trans('link.admin.select_target') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control target select2" style="width: 100%;" name="target" >
                                        <option value=""></option>
                                        @foreach ($arrTarget as $k => $v)
                                            <option value="{{ $k }}" {{ (old('target',$link['target']??'') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('target'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('target') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  {{ $errors->has('group') ? ' has-error' : '' }}">
                                <label for="group" class="col-sm-2 col-form-label">{{ trans('link.admin.select_group') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control group select2" style="width: 100%;" name="group" >
                                        <option value=""></option>
                                        @foreach ($arrGroup as $k => $v)
                                            <option value="{{ $k }}" {{ (old('group',$link['group']??'') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('group'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('group') }}
                                            </span>
                                        @endif
                                </div>
                            </div>



                            <div class="form-group   {{ $errors->has('sort') ? ' has-error' : '' }}">
                                <label for="sort" class="col-sm-2 col-form-label">{{ trans('link.sort') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="number" style="width: 100px;" min = 0 id="sort" name="sort" value="{!! old()?old('sort'):$link['sort']??0 !!}" class="form-control sort" placeholder="" />
                                    </div>
                                        @if ($errors->has('sort'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  ">
                                <label for="status" class="col-sm-2 col-form-label">{{ trans('link.status') }}</label>
                                <div class="col-sm-8">
                                <input class="input" type="checkbox" name="status"  {{ old('status',(empty($link['status'])?0:1))?'checked':''}}>

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

$(document).ready(function() {
    $('.select2').select2()
});

</script>

@endpush
