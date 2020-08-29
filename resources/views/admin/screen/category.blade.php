@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <h2 class="card-title">{{ $title_description??'' }}</h2>

                <div class="card-tools">
                    <div class="btn-group float-right mr-5">
                        <a href="{{ route('admin_category.index') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">


                <div class="card-body">
                    @php
                    $descriptions = $category?$category->descriptions->keyBy('lang')->toArray():[];
                    @endphp

                    @foreach ($languages as $code => $language)
                    
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">{{ $language->name }} {!! sc_image_render($language->icon,'20px','20px', $language->name) !!}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                </div>
                        </div>
                
                        <div class="card-body">

                        <div class="form-group row  {{ $errors->has('descriptions.'.$code.'.title') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__title"
                                class="col-sm-2 col-form-label">{{ trans('category.title') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="{{ $code }}__title" name="descriptions[{{ $code }}][title]"
                                        value="{!! old()? old('descriptions.'.$code.'.title'):($descriptions[$code]['title']??'') !!}"
                                        class="form-control {{ $code.'__title' }}" placeholder="" />
                                </div>
                                @if ($errors->has('descriptions.'.$code.'.title'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('descriptions.'.$code.'.title') }}
                                </span>
                                @else
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>200]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row  {{ $errors->has('descriptions.'.$code.'.keyword') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__keyword"
                                class="col-sm-2 col-form-label">{{ trans('category.keyword') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="{{ $code }}__keyword"
                                        name="descriptions[{{ $code }}][keyword]"
                                        value="{!! old()?old('descriptions.'.$code.'.keyword'):($descriptions[$code]['keyword']??'') !!}"
                                        class="form-control {{ $code.'__keyword' }}" placeholder="" />
                                </div>
                                @if ($errors->has('descriptions.'.$code.'.keyword'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('descriptions.'.$code.'.keyword') }}
                                </span>
                                @else
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>200]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row  {{ $errors->has('descriptions.'.$code.'.description') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__description"
                                class="col-sm-2 col-form-label">{{ trans('category.description') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                    <textarea type="text" id="{{ $code }}__description" 
                                        name="descriptions[{{ $code }}][description]"
                                        class="form-control {{ $code.'__description' }}" placeholder="" />{{  old()?old('descriptions.'.$code.'.description'):($descriptions[$code]['description']??'')  }}</textarea>
                                @if ($errors->has('descriptions.'.$code.'.description'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('descriptions.'.$code.'.description') }}
                                </span>
                                @else
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>300]) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                            </div>
                        </div>
                        @endforeach

                        {{-- select store --}}
                        @if (count($stories) > 1)
                        <div class="form-group row {{ $errors->has('store') ? ' text-red' : '' }}">
                            @php
                            $listStore = [];
                            $store = old('store', ($storiesPivot ?? []));
                            if(is_array($store)){
                                foreach($store as $value){
                                    $listStore[] = (int)$value;
                                }
                            }
                            @endphp
                            <label for="store" class="col-sm-2 col-form-label">
                                {{ trans('store.select_store') }}
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm store select2" multiple="multiple"
                                    data-placeholder="{{ trans('store.select_store') }}" style="width: 100%;"
                                    name="store[]">
                                    <option value="0" {{ (in_array(0, $listStore)) ? 'selected' : ''}}>{{ trans('store.all_stories') }}</option>
                                    @foreach ($stories as $id => $store)
                                    <option value="{{ $id }}"
                                        {{ (count($listStore) && in_array($id, $listStore))?'selected':'' }}>{{ sc_store('title', $id) }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('store'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('store') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="store[]" value="0">
                        @endif
                        {{-- //select store --}}

                        <div class="form-group row {{ $errors->has('parent') ? ' text-red' : '' }}">
                            <label for="parent"
                                class="col-sm-2 col-form-label">{{ trans('category.admin.select_category') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control parent select2" style="width: 100%;" name="parent">
                                    <option value=""></option>
                                    @php
                                    $categories = [0=>'==ROOT==']+ $categories;
                                    @endphp
                                    @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (old('parent',$category['parent']??'') ==$k) ? 'selected':'' }}>{{ $v }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('parent'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('parent') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row  {{ $errors->has('alias') ? ' text-red' : '' }}">
                            <label for="alias" class="col-sm-2 col-form-label">{!! trans('category.alias') !!}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="alias" name="alias"
                                        value="{!! old('alias',($category['alias']??'')) !!}" class="form-control"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('alias'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('alias') }}
                                </span>
                                @endif
                            </div>
                        </div>                        

                        <div class="form-group row  {{ $errors->has('image') ? ' text-red' : '' }}">
                            <label for="image" class="col-sm-2 col-form-label">{{ trans('category.image') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="image" name="image"
                                        value="{!! old('image',$category['image']??'') !!}"
                                        class="form-control input image" placeholder="" />
                                    <div class="input-group-append">
                                        <a data-input="image" data-preview="preview_image" data-type="category"
                                            class="btn btn-primary lfm">
                                            <i class="fa fa-image"></i> {{trans('product.admin.choose_image')}}
                                        </a>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                </span>
                                @endif
                                <div id="preview_image" class="img_holder">
                                    @if (old('image',$category['image']??''))
                                    <img src="{{ asset(old('image',$category['image']??'')) }}">
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="form-group row  {{ $errors->has('sort') ? ' text-red' : '' }}">
                            <label for="sort" class="col-sm-2 col-form-label">{{ trans('category.sort') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="sort" name="sort"
                                        value="{!! old()?old('sort'):$category['sort']??0 !!}" class="form-control sort"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('sort'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label for="top" class="col-sm-2 col-form-label">{{ trans('category.top') }}</label>
                            <div class="col-sm-8">
                                <input class="input" type="checkbox" name="top"
                                    {{ old('top',(empty($category['top'])?0:1))?'checked':''}}>
                            </div>
                            <span class="form-text">
                                <i class="fa fa-info-circle"></i> {{ trans('category.top_help') }}
                            </span>
                        </div>

                        <div class="form-group  row">
                            <label for="status" class="col-sm-2 col-form-label">{{ trans('category.status') }}</label>
                            <div class="col-sm-8">
                                <input class="input" type="checkbox" name="status"
                                    {{ old('status',(empty($category['status'])?0:1))?'checked':''}}>

                            </div>
                        </div>
                </div>



                <!-- /.card-body -->

                <div class="card-footer row" id="card-footer">
                    @csrf
                    <div class="col-md-2">
                    </div>

                    <div class="col-md-8">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                        </div>

                        <div class="btn-group float-left">
                            <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
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
    $(document).ready(function() {
    $('.select2').select2()
});



</script>

@endpush