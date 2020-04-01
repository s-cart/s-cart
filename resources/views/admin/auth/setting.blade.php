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
                                <label for="name" class="col-sm-2  control-label">{{ trans('user.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text"   id="name" name="name" value="{{ old('name',$user['name']??'')}}" class="form-control name" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-sm-2  control-label">{{ trans('user.user_name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" disabled=""  id="username"  value="{{ old('username',$user['username']??'') }}" class="form-control username" placeholder="" />
                                    </div>
                                        @if ($errors->has('username'))
                                            <span class="help-block">
                                                {{ $errors->first('username') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-sm-2  control-label">{{ trans('user.email') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" disabled=""  id="email"  value="{{ old('email',$user['email']??'') }}" class="form-control email" placeholder="" />
                                    </div>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('avatar') ? ' has-error' : '' }}">
                                <label for="avatar" class="col-sm-2  control-label">{{ trans('user.avatar') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="avatar" name="avatar" value="{{ old('avatar',$user['avatar']??'') }}" class="form-control input-sm avatar" placeholder=""  />
                                       <span class="input-group-btn">
                                         <a data-input="avatar" data-preview="preview_avatar" data-type="avatar" class="btn btn-sm btn-primary lfm">
                                           <i class="fa fa-picture-o"></i> {{trans('product.admin.choose_image')}}
                                         </a>
                                       </span>
                                    </div>
                                        @if ($errors->has('avatar'))
                                            <span class="help-block">
                                                {{ $errors->first('avatar') }}
                                            </span>
                                        @endif
                                    <div id="preview_avatar" class="img_holder"><img src="{{ asset(old('avatar',$user['avatar']??'')) }}"></div>
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-2  control-label">{{ trans('user.password') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="password"   id="password" name="password" value="{{ old('password')??'' }}" class="form-control password" placeholder="" />
                                    </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @else
                                            @if ($user)
                                                <span class="help-block">
                                                     {{ trans('user.admin.keep_password') }}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-2  control-label">{{ trans('user.password_confirmation') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="password"   id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation')??'' }}" class="form-control password_confirmation" placeholder="" />
                                    </div>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                {{ $errors->first('password_confirmation') }}
                                            </span>
                                        @else
                                            @if ($user)
                                                <span class="help-block">
                                                     {{ trans('user.admin.keep_password') }}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>

{{-- select roles --}}
                            <div class="form-group  {{ $errors->has('roles') ? ' has-error' : '' }}">
        @php
        $listRoles = [];
            $old_roles = old('roles',($user)?$user->roles->pluck('id')->toArray():'');
            if(is_array($old_roles)){
                foreach($old_roles as $value){
                    $listRoles[] = (int)$value;
                }
            }
        @endphp
                                <label for="roles" class="col-sm-2  control-label">{{ trans('user.admin.select_roles') }}</label>
                                <div class="col-sm-8">
                                    @if (count($listRoles))
                                        @foreach ($listRoles as $role)
                                            {!! '<span class="label label-primary">'.($roles[$role]??'').'</span>' !!}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
{{-- //select roles --}}

{{-- select permission --}}
                            <div class="form-group  {{ $errors->has('permission') ? ' has-error' : '' }}">
        @php
        $listPermission = [];
        $old_permission = old('permission',($user?$user->permissions->pluck('id')->toArray():''));
            if(is_array($old_permission)){
                foreach($old_permission as $value){
                    $listPermission[] = (int)$value;
                }
            }
        @endphp
                                <label for="permission" class="col-sm-2  control-label">{{ trans('user.admin.select_permission') }}</label>
                                <div class="col-sm-8">
                                    @if (count($listPermission))
                                        @foreach ($listPermission as $p)
                                            {!! '<span class="label label-primary">'.($permission[$p]??'').'</span>' !!}
                                        @endforeach
                                    @endif
                                </div>
                            </div>
{{-- //select permission --}}

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
