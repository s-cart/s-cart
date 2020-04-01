@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_user.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2  control-label">{{ trans('permission.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text"   id="name" name="name" value="{{ old('name',$permission['name']??'')}}" class="form-control name" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="slug" class="col-sm-2  control-label">{{ trans('permission.slug') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text"   id="slug" name="slug" value="{{ old('slug',$permission['slug']??'') }}" class="form-control slug" placeholder="" />
                                    </div>
                                        @if ($errors->has('slug'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('slug') }}
                                            </span>
                                        @endif
                                </div>
                            </div>




{{-- select http_method --}}
                            <div class="form-group  kind kind0 kind1 {{ $errors->has('http_uri') ? ' has-error' : '' }}">
    @php
        $old_http_uri = old('http_uri',($permission)?explode(',', $permission->http_uri):[]);
    @endphp
                                <label for="http_uri" class="col-sm-2  control-label">{{ trans('permission.admin.select_http_uri') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm http_uri select2"  multiple="multiple" data-placeholder="{{ trans('permission.admin.method_placeholder') }}" style="width: 100%;" name="http_uri[]" >
                                        <option value=""></option>
                                        @foreach ($routeAdmin as  $route)
                                            <option value="{{ $route['uri'] }}"  {{ in_array($route['uri'], $old_http_uri)?'selected':'' }}  >{{ $route['name']?$route['method'].'::'.$route['name']:$route['uri'] }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('http_uri'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('http_uri') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
{{-- //select http_uri --}}



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
