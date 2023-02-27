@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ sc_route_admin('admin_role.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                        <div class="fields-group">

                            <div class="form-group  row {{ $errors->has('name') ? ' text-red' : '' }}">
                                <label for="name" class="col-sm-2  control-label">{{ sc_language_render('admin.role.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text"   id="name" name="name" value="{{ old('name',$role['name']??'')}}" class="form-control name" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('slug') ? ' text-red' : '' }}">
                                <label for="slug" class="col-sm-2  control-label">{{ sc_language_render('admin.role.slug') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text"   id="slug" name="slug" value="{{ old('slug',$role['slug']??'') }}" class="form-control slug" placeholder="" />
                                    </div>
                                        @if ($errors->has('slug'))
                                            <span class="form-text">
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
            $listPermission[] = $value;
        }
    }
@endphp
                            <div class="form-group row {{ $errors->has('permission') ? ' text-red' : '' }}">
                                <label for="permission" class="col-sm-2  control-label">{{ sc_language_render('admin.role.select_permission') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control input-sm permission select2"  multiple="multiple" data-placeholder="{{ sc_language_render('admin.role.select_permission') }}" style="width: 100%;" name="permission[]" >
                                        <option value=""></option>
                                        @foreach ($permission as $k => $v)
                                            <option value="{{ $k }}"  {{ (count($listPermission) && in_array($k, $listPermission))?'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('permission'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('permission') }}
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
                        <div class="form-group row {{ $errors->has('administrators') ? ' text-red' : '' }}">
                            <label for="administrators" class="col-sm-2  control-label">{{ sc_language_render('admin.role.select_user') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm administrators select2"  multiple="multiple" data-placeholder="{{ sc_language_render('admin.role.select_user') }}" style="width: 100%;" name="administrators[]" >
                                    <option value=""></option>
                                    @foreach ($userList as $k => $v)
                                        <option value="{{ $k }}"  {{ (in_array($k, $old_administrators))?'selected':'' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                                    @if ($errors->has('administrators'))
                                        <span class="form-text">
                                            {{ $errors->first('administrators') }}
                                        </span>
                                    @endif
                            </div>
                        </div>
{{-- //select administrators --}}


                        </div>
                    </div>



                    <!-- /.card-body -->

                    <div class="card-footer row">
                            @csrf
                        <div class="col-md-2">
                        </div>

                        <div class="col-md-8">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                            </div>

                            <div class="btn-group float-left">
                                <button type="reset" class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->
                </form>

            </div>
        </div>
    </div>
@endsection

@push('styles')

@endpush

@push('scripts')


<script type="text/javascript">
</script>

@endpush
