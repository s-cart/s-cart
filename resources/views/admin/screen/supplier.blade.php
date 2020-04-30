@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_supplier.index') }}" class="btn  btn-flat btn-default" title="List"><i
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
                                    <label for="name" class="col-sm-2 col-form-label">{{ trans('supplier.name') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="name" name="name"
                                                value="{!! old()?old('name'):$supplier['name']??'' !!}"
                                                class="form-control" placeholder="" />
                                        </div>
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                        </span>
                                        @else
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>100]) }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('alias') ? ' has-error' : '' }}">
                                    <label for="alias" class="col-sm-2 col-form-label">{!! trans('supplier.alias') !!}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="alias" name="alias"
                                                value="{!! old()?old('alias'):$supplier['alias']??'' !!}"
                                                class="form-control" placeholder="" />
                                        </div>
                                        @if ($errors->has('alias'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('alias') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email"
                                        class="col-sm-2 col-form-label">{{ trans('supplier.email') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="email" id="email" name="email"
                                                value="{!! old()?old('email'):$supplier['email']??'' !!}"
                                                class="form-control" placeholder="" />
                                        </div>
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('email') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group   {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="phone"
                                        class="col-sm-2 col-form-label">{{ trans('supplier.phone') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="phone" name="phone"
                                                value="{!! old()?old('phone'):$supplier['phone']??'' !!}"
                                                class="form-control" placeholder="" />
                                        </div>
                                        @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('phone') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group   {{ $errors->has('url') ? ' has-error' : '' }}">
                                    <label for="url" class="col-sm-2 col-form-label">{{ trans('supplier.url') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="url" name="url"
                                                value="{!! old()?old('url'):$supplier['url']??'' !!}" class="form-control"
                                                placeholder="" />
                                        </div>
                                        @if ($errors->has('url'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('url') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group   {{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address"
                                        class="col-sm-2 col-form-label">{{ trans('supplier.address') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="text" id="address" name="address"
                                                value="{!! old()?old('address'):$supplier['address']??'' !!}"
                                                class="form-control" placeholder="" />
                                        </div>
                                        @if ($errors->has('address'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('address') }}
                                        </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group   {{ $errors->has('image') ? ' has-error' : '' }}">
                                    <label for="image"
                                        class="col-sm-2 col-form-label">{{ trans('supplier.image') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="text" id="image" name="image"
                                                value="{!! old('image',$supplier['image']??'') !!}"
                                                class="form-control input-sm image" placeholder="" />
                                            <span class="input-group-btn">
                                                <a data-input="image" data-preview="preview_image" data-type="supplier"
                                                    class="btn btn-sm btn-primary lfm">
                                                    <i class="fa fa-picture-o"></i>
                                                    {{trans('product.admin.choose_image')}}
                                                </a>
                                            </span>
                                        </div>
                                        @if ($errors->has('image'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                        </span>
                                        @endif
                                        <div id="preview_image" class="img_holder">
                                            @if (old('image',$supplier['image']??''))
                                            <img src="{{ asset(old('image',$supplier['image']??'')) }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group   {{ $errors->has('sort') ? ' has-error' : '' }}">
                                    <label for="sort" class="col-sm-2 col-form-label">{{ trans('supplier.sort') }}</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                            <input type="number" style="width: 100px;" min=0 id="sort" name="sort"
                                                value="{!! old()?old('sort'):$supplier['sort']??0 !!}"
                                                class="form-control sort" placeholder="" />
                                        </div>
                                        @if ($errors->has('sort'))
                                        <span class="help-block">
                                            <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                        </span>
                                        @endif
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