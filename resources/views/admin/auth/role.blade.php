@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_role.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2  control-label">{{ trans('role.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text"   id="name" name="name" value="{{ old('name',$role['name']??'')}}" class="form-control name" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('slug') ? ' has-error' : '' }}">
                                <label for="slug" class="col-sm-2  control-label">{{ trans('role.slug') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text"   id="slug" name="slug" value="{{ old('slug',$role['slug']??'') }}" class="form-control slug" placeholder="" />
                                    </div>
                                        @if ($errors->has('slug'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('slug') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

{{-- select permission --}}
@php
$listPermission = [];
$old_permission = old('permission',($role?$role->permissions->pluck('id')->toArray():''));
    if(is_array($old_permission)){
        foreach($old_permission as $value){
            $listPermission[] = (int)$value;
        }
    }
@endphp
                            <div class="form-group  {{ $errors->has('permission') ? ' has-error' : '' }}">
                                <label for="permission" class="col-sm-2  control-label">{{ trans('role.admin.select_permission') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm permission select2"  multiple="multiple" data-placeholder="{{ trans('role.admin.select_permission') }}" style="width: 100%;" name="permission[]" >
                                        <option value=""></option>
                                        @foreach ($permission as $k => $v)
                                            <option value="{{ $k }}"  {{ (count($listPermission) && in_array($k, $listPermission))?'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('permission'))
                                            <span class="help-block">
                                                {{ $errors->first('permission') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
{{-- //select permission --}}


{{-- select administrators --}}
@php
$listadministrators = [];
$roleCheck = $role ? $role->administrators->pluck('name', 'id')->all():[];
$old_administrators = old('administrators',array_keys($roleCheck));
@endphp
                        <div class="form-group  {{ $errors->has('administrators') ? ' has-error' : '' }}">
                            <label for="administrators" class="col-sm-2  control-label">{{ trans('role.admin.select_user') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm administrators select2"  multiple="multiple" data-placeholder="{{ trans('role.admin.select_user') }}" style="width: 100%;" name="administrators[]" >
                                    <option value=""></option>
                                    @foreach ($userList as $k => $v)
                                        <option value="{{ $k }}"  {{ (in_array($k, $old_administrators))?'selected':'' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                                    @if ($errors->has('administrators'))
                                        <span class="help-block">
                                            {{ $errors->first('administrators') }}
                                        </span>
                                    @endif
                            </div>
                        </div>
{{-- //select administrators --}}


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
