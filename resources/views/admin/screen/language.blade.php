@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_language.index') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">


                <div class="box-body">
                    <div class="fields-group">

                                <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name"
                                        class="col-sm-2 col-form-label">{{ trans('language.name') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="name" name="name"
                                                value="{!! old()?old('name'):$language['name']??'' !!}"
                                                class="form-control" placeholder="" />
                                        </div>
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            {{ $errors->first('name') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('code') ? ' has-error' : '' }}">
                                    <label for="code"
                                        class="col-sm-2 col-form-label">{{ trans('language.code') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            @if (!empty($language['code']) && in_array($language['code'], ['vi','en']))
                                            <input type="hidden" id="code" name="code" value="{!! $language['code'] !!}"
                                                placeholder="" />
                                            <input type="text" disabled="disabled" value="{!! $language['code'] !!}"
                                                class="form-control" placeholder="" />
                                            @else
                                            <input type="text" id="code" name="code"
                                                value="{!! old()?old('code'):$language['code']??'' !!}"
                                                class="form-control" placeholder="" />
                                            @endif
                                        </div>
                                        @if ($errors->has('code'))
                                        <span class="help-block">
                                            {{ $errors->first('code') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group   {{ $errors->has('icon') ? ' has-error' : '' }}">
                                    <label for="icon"
                                        class="col-sm-2 col-form-label">{{ trans('language.icon') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="icon" name="icon"
                                                value="{!! old('icon',$language['icon']??'') !!}"
                                                class="form-control input-sm icon" placeholder="" />
                                            <span class="input-group-btn">
                                                <a data-input="icon" data-preview="preview_icon" data-type="language"
                                                    class="btn btn-sm btn-primary lfm">
                                                    <i class="fa fa-picture-o"></i>
                                                    {{trans('admin.choose_icon')}}
                                                </a>
                                            </span>
                                        </div>
                                        @if ($errors->has('icon'))
                                        <span class="help-block">
                                            {{ $errors->first('icon') }}
                                        </span>
                                        @endif
                                        <div id="preview_icon" class="img_holder"><img
                                                src="{{ asset(old('icon',$language['icon']??'')) }}"></div>
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('rtl') ? ' has-error' : '' }}">
                                    <label for="rtl"
                                        class="col-sm-2 col-form-label">{{ trans('language.layout_rtl') }}</label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="rtl" {!!
                                                old('rtl',(empty($language['rtl'])?0:1))?'checked':''!!}>
    
                                        </div>
                                </div>

                                <div class="form-group   {{ $errors->has('sort') ? ' has-error' : '' }}">
                                    <label for="sort"
                                        class="col-sm-2 col-form-label">{{ trans('language.sort') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="number" style="width: 100px;" min=0 id="sort" name="sort"
                                                value="{!! old()?old('sort'):$language['sort']??0 !!}"
                                                class="form-control sort" placeholder="" />
                                        </div>
                                        @if ($errors->has('sort'))
                                        <span class="help-block">
                                            {{ $errors->first('sort') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group  ">
                                    <label for="status"
                                        class="col-sm-2 col-form-label">{{ trans('language.status') }}</label>
                                    <div class="col-sm-8">
                                        <input class="input" type="checkbox" name="status" {!!
                                            old('status',(empty($language['status'])?0:1))?'checked':''!!}>

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