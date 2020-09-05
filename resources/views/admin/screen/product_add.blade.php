@extends('admin.layout')

@section('main')
@php
    $kindOpt = old('kind', '');
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <h2 class="card-title">{{ $title_description??'' }}</h2>
                <div class="card-tools">
                    <div class="btn-group float-right mr-5">
                        <a href="{{ route('admin_product.index') }}" class="btn  btn-flat btn-default" title="List">
                            <i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->


            <!-- form start -->
            <form action="{{ route('admin_product.create') }}" method="post" name="form_name" accept-charset="UTF-8" 
                class="form-horizontal" id="form-main" enctype="multipart/form-data">

                <div class="d-flex d-flex justify-content-center mb-3 {{ $errors->has('kind') ? ' text-red' : '' }}"  id="start-add">
                    <div class="input-group" style="width: 300px; z-index:999">
                        @if (sc_config('product_kind'))
                        <select class="form-control" style="width: 100%;" name="kind">
                            <option value="">{{ trans('product.admin.select_kind') }}</option>
                            @foreach ($kinds as $key => $kind)
                            <option value="{{ $key }}" {{ (old() && (int)old('kind') === $key)?'selected':'' }}>
                                {!! $kind !!}
                            </option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <span class="input-group">
                                &nbsp; <i class="far fa-hand-point-left fa-2x"></i>
                            </span>
                        </div>                                                
                        @else
                            <select class="form-control" style="display:none" name="kind">
                                <option value="0" selected="selected">{{ $kinds[0] }}</option>
                            </select>
                        @endif
                    </div>
                    @if ($errors->has('kind'))
                    <span class="text-sm">
                        <i class="fa fa-info-circle"></i> {{ $errors->first('kind') }}
                    </span>
                    @endif
                </div>

                <div id="main-add" class="card-body {{ 'kind'.$kindOpt }}">
                        {{-- descriptions --}}
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
                        <div
                            class="form-group row {{ $errors->has('descriptions.'.$code.'.name') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__name"
                                class="col-sm-2 col-form-label">{{ trans('product.name') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span>
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="{{ $code }}__name" name="descriptions[{{ $code }}][name]"
                                        value="{!! old('descriptions.'.$code.'.name') !!}"
                                        class="form-control input-sm {{ $code.'__name' }}" placeholder="" />
                                </div>
                                @if ($errors->has('descriptions.'.$code.'.name'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.name') }}
                                </span>
                                @else
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>200]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row   {{ $errors->has('descriptions.'.$code.'.keyword') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__keyword"
                                class="col-sm-2 col-form-label">{{ trans('product.keyword') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" id="{{ $code }}__keyword"
                                        name="descriptions[{{ $code }}][keyword]"
                                        value="{!! old('descriptions.'.$code.'.keyword') !!}"
                                        class="form-control input-sm {{ $code.'__keyword' }}" placeholder="" />
                                </div>
                                @if ($errors->has('descriptions.'.$code.'.keyword'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.keyword') }}
                                </span>
                                @else
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>200]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-group row {{ $errors->has('descriptions.'.$code.'.description') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__description"
                                class="col-sm-2 col-form-label">{{ trans('product.description') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                            <div class="col-sm-8">
                                    <textarea id="{{ $code }}__description"
                                        name="descriptions[{{ $code }}][description]"
                                        class="form-control input-sm {{ $code.'__description' }}" placeholder="" />{{ old('descriptions.'.$code.'.description') }}</textarea>
                                @if ($errors->has('descriptions.'.$code.'.description'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.description') }}
                                </span>
                                @else
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>300]) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row kind kind0 {{ $errors->has('descriptions.'.$code.'.content') ? ' text-red' : '' }}">
                            <label for="{{ $code }}__content" class="col-sm-2 col-form-label">
                                {{ trans('product.content') }}
                            </label>
                            <div class="col-sm-8">
                                <textarea id="{{ $code }}__content" class="editor"
                                    name="descriptions[{{ $code }}][content]">
                                        {!! old('descriptions.'.$code.'.content') !!}
                                    </textarea>
                                @if ($errors->has('descriptions.'.$code.'.content'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i>
                                    {{ $errors->first('descriptions.'.$code.'.content') }}
                                </span>
                                @endif
                            </div>
                        </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- //descriptions --}}


                        {{-- select category --}}
                        <div class="form-group row kind kind0 kind1 {{ $errors->has('category') ? ' text-red' : '' }}">
                            @php
                            $listCate = [];
                            if (is_array(old('category'))) {
                                foreach(old('category') as $value){
                                    $listCate[] = (int)$value;
                                }
                            }
                            @endphp
                            <label for="category" class="col-sm-2 col-form-label">
                                {{ trans('product.admin.select_category') }}
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm category select2" multiple="multiple"
                                    data-placeholder="{{ trans('product.admin.select_category') }}" style="width: 100%;"
                                    name="category[]">
                                    <option value=""></option>
                                    @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (count($listCate) && in_array($k, $listCate))?'selected':'' }}>{{ $v }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('category') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //select category --}}

                        {{-- select store --}}
                        @if (count($stories) > 1)
                        <div class="form-group row {{ $errors->has('store') ? ' text-red' : '' }}">
                            @php
                            $listStore = [];
                            if (is_array(old('store'))) {
                                foreach(old('store') as $value){
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
                                    <option value="0" {{ (in_array(0, $listStore) || !is_array(old('store'))) ? 'selected' : ''}}>{{ trans('store.all_stories') }}</option>
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


                        {{-- images --}}
                        <div class="form-group row kind kind0 kind1 {{ $errors->has('image') ? ' text-red' : '' }}">
                            <label for="image" class="col-sm-2 col-form-label">
                                {{ trans('product.image') }}
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="image" name="image" value="{!! old('image') !!}"
                                        class="form-control input-sm image" placeholder="" />
                                    <div class="input-group-append">
                                        <span class="btn btn-primary lfm" data-input="image" data-preview="preview_image" data-type="product">
                                            <i class="fas fa-image"></i> {{trans('product.admin.choose_image')}}
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('image') }}
                                </span>
                                @endif
                                <div id="preview_image" class="img_holder">
                                    @if (old('image'))
                                        <img src="{{ asset(old('image')) }}">
                                    @endif
                                    
                                </div>

                                @if (!empty(old('sub_image')))
                                @foreach (old('sub_image') as $key => $sub_image)
                                @if ($sub_image)
                                <div class="group-image">
                                    <div class="input-group"><input type="text" id="sub_image_{{ $key }}"
                                            name="sub_image[]" value="{!! $sub_image !!}"
                                            class="form-control input-sm sub_image" placeholder="" /><span
                                            class="input-group-btn"><span><a data-input="sub_image_{{ $key }}"
                                                    data-preview="preview_sub_image_{{ $key }}" data-type="product"
                                                    class="btn btn-flat btn-primary lfm"><i
                                                        class="fa fa-image"></i>
                                                    {{trans('product.admin.choose_image')}}</a></span><span
                                                title="Remove" class="btn btn-flat btn-danger removeImage"><i
                                                    class="fa fa-times"></i></span></span></div>
                                    <div id="preview_sub_image_{{ $key }}" class="img_holder"><img
                                            src="{{ asset($sub_image) }}"></div>
                                </div>

                                @endif
                                @endforeach
                                @endif

                                <button type="button" id="add_sub_image" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_sub_image') }}
                                </button>
                            </div>

                        </div>
                        {{-- //images --}}

                        {{-- sku --}}
                        <div class="form-group row kind kind0 kind1 kind2 {{ $errors->has('sku') ? ' text-red' : '' }}">
                            <label for="sku" class="col-sm-2 col-form-label">{{ trans('product.sku') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text" style="width: 100px;" id="sku" name="sku"
                                        value="{!! old('sku')??'' !!}" class="form-control input-sm sku"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('sku'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('sku') }}
                                </span>
                                @else
                                <span class="form-text">
                                    {{ trans('product.sku_validate') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //sku --}}


                        {{-- alias --}}
                        <div class="form-group row kind kind0 kind1 kind2 {{ $errors->has('alias') ? ' text-red' : '' }}">
                            <label for="alias" class="col-sm-2 col-form-label">{!! trans('product.alias') !!}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="text"  id="alias" name="alias"
                                        value="{!! old('alias')??'' !!}" class="form-control input-sm alias"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('alias'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('alias') }}
                                </span>
                                @else
                                <span class="form-text">
                                    {{ trans('product.alias_validate') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //alias --}}

@if (sc_config('product_brand'))
                        {{-- select brand --}}
                        <div class="form-group row kind kind0 kind1  {{ $errors->has('brand_id') ? ' text-red' : '' }}">
                            <label for="brand_id"
                                class="col-sm-2 col-form-label">{{ trans('product.brand') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm brand_id select2" style="width: 100%;"
                                    name="brand_id">
                                    <option value=""></option>
                                    @foreach ($brands as $k => $v)
                                    <option value="{{ $k }}" {{ (old('brand_id') ==$k) ? 'selected':'' }}>{{ $v->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('brand_id'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('brand_id') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //select brand --}}   
@endif


@if (sc_config('product_supplier'))
                        {{-- select supplier --}}
                        <div class="form-group row kind kind0 kind1  {{ $errors->has('supplier_id') ? ' text-red' : '' }}">
                            @php
                            $listSupplier = [];
                            if(is_array(old('supplier_id'))){
                            foreach(old('supplier_id') as $value){
                            $listSupplier[] = (int)$value;
                            }
                            }
                            @endphp
                            <label for="supplier_id"
                                class="col-sm-2 col-form-label">{{ trans('product.supplier') }}</label>
                            <div class="col-sm-8">
                            <select class="form-control input-sm supplier_id select2" multiple="multiple"
                                data-placeholder="{{ trans('product.admin.select_supplier') }}" style="width: 100%;"
                                name="supplier_id[]">
                                <option value=""></option>
                                @foreach ($suppliers as $k => $v)
                                <option value="{{ $k }}"
                                    {{ (count($listSupplier) && in_array($v->id, $listSupplier))?'selected':'' }}>{{ $v->name }}
                                </option>
                                @endforeach
                            </select>
                                @if ($errors->has('supplier_id'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('supplier_id') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{--// select supplier --}}
@endif

@if (sc_config('product_cost'))
                        {{-- cost --}}
                        <div class="form-group row kind kind0 kind1  {{ $errors->has('cost') ? ' text-red' : '' }}">
                            <label for="cost" class="col-sm-2 col-form-label">{{ trans('product.cost') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="cost" name="cost"
                                        value="{!! old('cost')??0 !!}" class="form-control input-sm cost"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('cost'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('cost') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //cost --}}
@endif

@if (sc_config('product_price'))
                        {{-- price --}}
                        <div class="form-group row kind kind0 kind1  {{ $errors->has('price') ? ' text-red' : '' }}">
                            <label for="price" class="col-sm-2 col-form-label">{{ trans('product.price') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="price" name="price"
                                        value="{!! old('price')??0 !!}" class="form-control input-sm price"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('price'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('price') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //price --}}
@endif


@if (sc_config('product_tax'))
                        {{-- select tax --}}
                        <div class="form-group row kind kind0 kind1  {{ $errors->has('tax_id') ? ' text-red' : '' }}">
                            <label for="tax_id"
                                class="col-sm-2 col-form-label">{{ trans('product.tax') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm tax_id select2" style="width: 100%;"
                                    name="tax_id">
                                    <option value="0" {{ (old('tax_id') == 0) ? 'selected':'' }}>{{ trans('tax.admin.non_tax') }}</option>
                                    <option value="auto" {{ (old('tax_id') == 'auto') ? 'selected':'' }}>{{ trans('tax.admin.auto') }}</option>
                                    @foreach ($taxs as $k => $v)
                                    <option value="{{ $k }}" {{ (old('tax_id') ==$k) ? 'selected':'' }}>{{ $v->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tax_id'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('tax_id') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //select tax --}}   
@endif

@if (sc_config('product_promotion'))
                        {{-- price promotion --}}
                        <div class="form-group row kind kind0 kind1   {{ $errors->has('price_promotion') ? ' text-red' : '' }}">
                            <label for="price"
                                class="col-sm-2 col-form-label">{{ trans('product.price_promotion') }}</label>
                            <div class="col-sm-8">
                                @if (old('price_promotion'))
                                <div class="price_promotion">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="number" style="width: 100px;" id="price_promotion"
                                            name="price_promotion" value="{!! old('price_promotion')??0 !!}"
                                            class="form-control input-sm price" placeholder="" />
                                        <span title="Remove" class="btn btn-flat btn-danger removePromotion"><i
                                                class="fa fa-times"></i></span>
                                    </div>

                                    <div class="form-inline">
                                        <div class="input-group">
                                            {{ trans('product.price_promotion_start') }}<br>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>
                                                </div>
                                                <input type="date" style="width: 100px;" id="price_promotion_start"
                                                    name="price_promotion_start"
                                                    value="{!!old('price_promotion_start')!!}"
                                                    class="form-control input-sm price_promotion_start date_time"
                                                    placeholder="" />
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            {{ trans('product.price_promotion_end') }}<br>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>
                                                </div>
                                                <input type="date" style="width: 100px;" id="price_promotion_end"
                                                    name="price_promotion_end" value="{!!old('price_promotion_end')!!}"
                                                    class="form-control input-sm price_promotion_end date_time"
                                                    placeholder="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <button type="button" id="add_product_promotion" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product_promotion') }}
                                </button>
                                @endif
                                @if ($errors->has('price_promotion'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('price_promotion') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //price promotion --}}
@endif

@if (sc_config('product_stock'))
                        {{-- stock --}}
                        <div class="form-group row kind kind0  kind1 {{ $errors->has('stock') ? ' text-red' : '' }}">
                            <label for="stock" class="col-sm-2 col-form-label">{{ trans('product.stock') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="stock" name="stock"
                                        value="{!! old('stock')??0 !!}" class="form-control input-sm stock"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('stock'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('stock') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //stock --}}
@endif



@if (sc_config('product_weight'))
                        {{-- weight --}}
                        <div class="form-group row kind kind0  kind1  {{ $errors->has('weight_class') ? ' text-red' : '' }}">
                            <label for="weight_class" class="col-sm-2 col-form-label">{{ trans('product.weight_class') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm weight_class select2" style="width: 100%;"
                                    name="weight_class">
                                    <option value="">{{ trans('product.select_weight') }}<option>
                                    @foreach ($listWeight as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (old('weight_class') == $k || (!old()) ) ? 'selected':'' }}>
                                        {{ $v }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('weight_class'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('weight_class') }}
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row kind kind0  kind1 {{ $errors->has('weight') ? ' text-red' : '' }}">
                            <label for="weight" class="col-sm-2 col-form-label">{{ trans('product.weight') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="weight" name="weight"
                                        value="{!! old('weight', 0) !!}" class="form-control input-sm weight"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('weight'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('weight') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //weight --}}
@endif


@if (sc_config('product_length'))
                        {{-- length --}}
                        <div class="form-group row kind kind0  kind1  {{ $errors->has('length_class') ? ' text-red' : '' }}">
                            <label for="length_class" class="col-sm-2 col-form-label">{{ trans('product.length_class') }}</label>
                            <div class="col-sm-8">
                                <select class="form-control input-sm length_class select2" style="width: 100%;"
                                    name="length_class">
                                    <option value="">{{ trans('product.select_length') }}<option>
                                    @foreach ($listLength as $k => $v)
                                    <option value="{{ $k }}"
                                        {{ (old('length_class') == $k || (!old()) ) ? 'selected':'' }}>
                                        {{ $v }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('length_class'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('length_class') }}
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row kind kind0  kind1 {{ $errors->has('length') ? ' text-red' : '' }}">
                            <label for="length" class="col-sm-2 col-form-label">{{ trans('product.length') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="length" name="length"
                                        value="{!! old('length', 0) !!}" class="form-control input-sm length"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('length'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('length') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row kind kind0  kind1 {{ $errors->has('height') ? ' text-red' : '' }}">
                            <label for="height" class="col-sm-2 col-form-label">{{ trans('product.height') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="height" name="height"
                                        value="{!! old('height', 0) !!}" class="form-control input-sm height"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('height'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('height') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row kind kind0  kind1 {{ $errors->has('width') ? ' text-red' : '' }}">
                            <label for="width" class="col-sm-2 col-form-label">{{ trans('product.width') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="width" name="width"
                                        value="{!! old('width', 0) !!}" class="form-control input-sm width"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('width'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('width') }}
                                </span>
                                @endif
                            </div>
                        </div>                        
                        {{-- //length --}}
@endif


@if (sc_config('product_property'))
                        {{-- property --}}
                        <div class="form-group row kind kind0 kind1  {{ $errors->has('property') ? ' text-red' : '' }}">
                            <label for="property" class="col-sm-2 col-form-label">{{ trans('product.property') }}</label>
                            <div class="col-sm-8">
                                @foreach ( $propertys as $key => $property)
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary{{ $key }}" name="property" value="{{ $key }}" {{ ((!old() && $key ==0) || old('property') == $key)?'checked':'' }}>
                                    <label for="radioPrimary{{ $key }}">
                                        {{ $property }}
                                    </label>
                                </div>
                                @endforeach
                                @if ($errors->has('property'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('property') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //property --}}
@endif


@if (sc_config('product_available'))
                        {{-- date available --}}
                        <div
                            class="form-group row kind kind0 kind1  {{ $errors->has('date_available') ? ' text-red' : '' }}">
                            <label for="date_available"
                                class="col-sm-2 col-form-label">{{ trans('product.date_available') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span>
                                    </div>
                                    <input type="date" data-date-format="yyyy-mm-dd" style="width: 100px;" id="date_available" name="date_available"
                                        value="{!!old('date_available')!!}"
                                        class="form-control input-sm date_available date_time" placeholder="" />
                                </div>
                                @if ($errors->has('date_available'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('date_available') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //date available --}}
@endif

                        {{-- minimum --}}
                        <div class="form-group row   {{ $errors->has('minimum') ? ' text-red' : '' }}">
                            <label for="minimum" class="col-sm-2 col-form-label">{{ trans('product.minimum') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="minimum" name="minimum"
                                        value="{!! old('minimum')??0 !!}" class="form-control input-sm minimum"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('minimum'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('minimum') }}
                                </span>
                                @else
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ trans('product.minimum_help') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //minimum --}}

                        {{-- sort --}}
                        <div class="form-group row   {{ $errors->has('sort') ? ' text-red' : '' }}">
                            <label for="sort" class="col-sm-2 col-form-label">{{ trans('product.sort') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                    <input type="number" style="width: 100px;" id="sort" name="sort"
                                        value="{!! old('sort')??0 !!}" class="form-control input-sm sort"
                                        placeholder="" />
                                </div>
                                @if ($errors->has('sort'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //sort --}}


                        {{-- status --}}
                        <div class="form-group row ">
                            <label for="status" class="col-sm-2 col-form-label">{{ trans('product.status') }}</label>
                            <div class="col-sm-8">
                                @if (old())
                                <input class="input" type="checkbox" name="status" {{ ((old('status') ==='on')?'checked':'')}}>
                                @else
                                <input class="input" type="checkbox" name="status" checked>
                                @endif

                            </div>
                        </div>
                        {{-- //status --}}

@if (sc_config('product_kind'))
                        <hr class="kind kind2">
                        {{-- List product in groups --}}
                        <div class="form-group row kind kind2 {{ $errors->has('productInGroup') ? ' text-red' : '' }}">
                            
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-8"><label>{{ trans('product.admin.select_product_in_group') }}</label>
                            </div>
                        </div>
                        <div class="form-group row kind kind2 {{ $errors->has('productInGroup') ? ' text-red' : '' }}">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                @if (old('productInGroup'))
                                @foreach (old('productInGroup') as $pID)
                                @if ( (int)$pID)
                                @php
                                $newHtml = str_replace('value="'.(int)$pID.'"', 'value="'.(int)$pID.'" selected',
                                $htmlSelectGroup);
                                @endphp
                                {!! $newHtml !!}
                                @endif
                                @endforeach
                                @endif
                                <button type="button" id="add_product_in_group" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product') }}
                                </button>
                                @if ($errors->has('productInGroup'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('productInGroup') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        {{-- //end List product in groups --}}

                        <hr class="kind kind2">
                        {{-- List product build --}}
                        <div class="form-group row kind kind1 {{ $errors->has('productBuild') ? ' text-red' : '' }}">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-8">
                                <label>{{ trans('product.admin.select_product_in_build') }}</label>
                            </div>
                        </div>

                        <div
                            class="form-group row kind kind1 {{ ($errors->has('productBuild') || $errors->has('productBuildQty'))? ' text-red' : '' }}">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-8">

                                @if (old('productBuild'))
                                @foreach (old('productBuild') as $key => $pID)
                                @if ( (int)$pID && (int)old('productBuildQty')[$key])
                                @php
                                $newHtml = str_replace('value="'.(int)$pID.'"', 'value="'.(int)$pID.'" selected',
                                $htmlSelectBuild);
                                $newHtml = str_replace('name="productBuildQty[]" value="1" min=1',
                                'name="productBuildQty[]" value="'.(int)old('productBuildQty')[$key].'"', $newHtml);
                                @endphp
                                {!! $newHtml !!}
                                @endif
                                @endforeach
                                @endif
                                <button type="button" id="add_product_in_build" class="btn btn-flat btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ trans('product.admin.add_product') }}
                                </button>
                                @if ($errors->has('productBuild') || $errors->has('productBuildQty'))
                                <span class="form-text">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('productBuild') }}
                                </span>
                                @endif

                            </div>
                        </div>
                        {{-- //end List product build --}}
@endif


@if (sc_config('product_attribute'))
                        {{-- List product attributes --}}

                        @if (!empty($attributeGroup))

                        @php
                        $dataAtt = old('attribute');
                        @endphp


                        <hr class="kind kind0">
                        <div class="form-group kind kind0 row">
                            <div class="col-sm-2">
                                <label>{{ trans('product.attribute') }}</label>
                            </div>
                            <div class="col-sm-8">
                                @foreach ($attributeGroup as $attGroupId => $attName)
                                <table width="100%">
                                    <tr>
                                        <td colspan="3"><p><b>{{ $attName }}:</b></p></td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('product.admin.add_attribute_place') }}</td>
                                        <td>{{ trans('product.admin.add_price_place') }}</td>
                                    </tr>
                                @if (!empty($dataAtt[$attGroupId]['name']))
                                    @foreach ($dataAtt[$attGroupId]['name'] as $key => $attValue)
                                        @php
                                        $newHtml = str_replace('attribute_group', $attGroupId, $htmlProductAtrribute);
                                        $newHtml = str_replace('attribute_value', $attValue, $newHtml);
                                        $newHtml = str_replace('add_price_value', $dataAtt[$attGroupId]['add_price'][$key], $newHtml);
                                        @endphp
                                        {!! $newHtml !!}
                                    @endforeach
                                @endif
                                    <tr>
                                        <td colspan="3"><br><button type="button"
                                                class="btn btn-flat btn-success add_attribute"
                                                data-id="{{ $attGroupId }}">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                {{ trans('product.admin.add_attribute') }}
                                            </button><br><br></td>
                                    </tr>
                                </table>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        {{-- //end List product attributes --}}
@endif

                </div>



                <!-- /.card-body -->


                <div class="card-footer kind kind0  kind1 kind2 row" id="card-footer">
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
<style>
    #start-add {
        margin: 20px;
    }
    #main-add.kind0 .kind:not(.kind0),
    #main-add.kind1 .kind:not(.kind1),
    #main-add.kind2 .kind:not(.kind2)
    {
        display: none;
    }
    @if($kindOpt == '')
        #main-add, #card-footer {
            display: none;
        }
    @endif 
</style>

@endpush

@push('scripts')
@include('admin.component.ckeditor_js')

<script type="text/javascript">
    // Promotion
$('#add_product_promotion').click(function(event) {
    $(this).before(
        '<div class="price_promotion">'
        +'<div class="input-group"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-pencil-alt"></i></span></div>'
        +'  <input type="number"  id="price_promotion" name="price_promotion" value="0" class="form-control input-sm price" placeholder="" />'
        +'  <span title="Remove" class="btn btn-flat btn-danger removePromotion"><i class="fa fa-times"></i></span>'
        +'</div>'
        +'<div class="form-inline">'
        +'  <div class="input-group">'
        +'  {{ trans('product.price_promotion_start') }}<br>'
        +'      <div class="input-group">'
        +'          <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span></div>'
        +'          <input type="date" style="width: 150px;"  id="price_promotion_start" name="price_promotion_start" value="" class="form-control input-sm price_promotion_start date_time" placeholder="" />'
        +'      </div>'
        +'  </div>'
        +'  <div class="input-group">{{ trans('product.price_promotion_end') }}<br>'
        +'      <div class="input-group">'
        +'          <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar fa-fw"></i></span></div>'
        +'          <input type="date" style="width: 150px;"  id="price_promotion_end" name="price_promotion_end" value="" class="form-control input-sm price_promotion_end date_time" placeholder="" />'
        +'      </div>'
        +'  </div>'
        +'  </div>'
        +'</div>');
    $(this).hide();
    $('.removePromotion').click(function(event) {
        $(this).closest('.price_promotion').remove();
        $('#add_product_promotion').show();
    });
    /* $('.date_time').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    }) */
});
$('.removePromotion').click(function(event) {
    $('#add_product_promotion').show();
    $(this).closest('.price_promotion').remove();
});
//End promotion

// Add sub images
var id_sub_image = {{ old('sub_image')?count(old('sub_image')):0 }};
$('#add_sub_image').click(function(event) {
    id_sub_image +=1;
    $(this).before(
    '<div class="group-image">'
    +'<div class="input-group">'
    +'  <input type="text" id="sub_image_'+id_sub_image+'" name="sub_image[]" value="" class="form-control input-sm sub_image" placeholder=""  />'
    +'  <div class="input-group-append">'
    +'  <span data-input="sub_image_'+id_sub_image+'" data-preview="preview_sub_image_'+id_sub_image+'" data-type="product" class="btn btn-flat btn-primary lfm">'
    +'      <i class="fa fa-image"></i> {{trans('product.admin.choose_image')}}'
    +'  </span>'
    +' </div>'
    +'<span title="Remove" class="btn btn-flat btn-danger removeImage"><i class="fa fa-times"></i></span>'
    +'</div>'
    +'<div id="preview_sub_image_'+id_sub_image+'" class="img_holder"></div>'
    +'</div>');
    $('.removeImage').click(function(event) {
        $(this).closest('div').remove();
    });
    $('.lfm').filemanager();
});
    $('.removeImage').click(function(event) {
        $(this).closest('.group-image').remove();
    });
//end sub images

// Select product in group
$('#add_product_in_group').click(function(event) {
    var htmlSelectGroup = '{!! $htmlSelectGroup !!}';
    $(this).before(htmlSelectGroup);
    $('.select2').select2();
    $('.removeproductInGroup').click(function(event) {
        $(this).closest('table').remove();
    });
});
$('.removeproductInGroup').click(function(event) {
    $(this).closest('table').remove();
});
//end select in group

// Select product in build
$('#add_product_in_build').click(function(event) {
    var htmlSelectBuild = '{!! $htmlSelectBuild !!}';
    $(this).before(htmlSelectBuild);
    $('.select2').select2();
    $('.removeproductBuild').click(function(event) {
        $(this).closest('table').remove();
    });
});
$('.removeproductBuild').click(function(event) {
    $(this).closest('table').remove();
});
//end select in build


// Select product attributes
$('.add_attribute').click(function(event) {
    var htmlProductAtrribute = '{!! $htmlProductAtrribute??'' !!}';
    var attGroup = $(this).attr("data-id");
    htmlProductAtrribute = htmlProductAtrribute.replace(/attribute_group/gi, attGroup);
    htmlProductAtrribute = htmlProductAtrribute.replace("attribute_value", "");
    htmlProductAtrribute = htmlProductAtrribute.replace("add_price_value", "0");
    $(this).closest('tr').before(htmlProductAtrribute);
    $('.removeAttribute').click(function(event) {
        $(this).closest('tr').remove();
    });
});
$('.removeAttribute').click(function(event) {
    $(this).closest('tr').remove();
});
//end select attributes

$(document).ready(function() {
    $('.select2').select2();
});
// image
// with plugin options
// $("input.image").fileinput({"browseLabel":"Browse","cancelLabel":"Cancel","showRemove":true,"showUpload":false,"dropZoneEnabled":false});

/* process_form(); */

$('[name="kind"]').change(function(event) {
    process_form();
});

function process_form(){
    var kind = $('[name="kind"] option:selected').val();
    if(kind){
        $('#loading').show();
        setTimeout(
            function(){
                $('#main-add').removeClass('kind');
                $('#main-add').removeClass('kind0');
                $('#main-add').removeClass('kind1');
                $('#main-add').removeClass('kind2');
                $('#main-add').addClass('kind'+kind);
                $('#main-add').show();
                 $('#loading').hide();
                  }
            , 500);
        $('#card-footer').show();
    }else{
        Swal.fire(
          '{{ trans('product.admin.select_kind') }}',
          '',
          'error'
        );
        $('#main-add').hide();
        $('#card-footer').hide();
    }
}

$('textarea.editor').ckeditor(
    {
        filebrowserImageBrowseUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}?type=product',
        filebrowserImageUploadUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=product&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}?type=Files',
        filebrowserUploadUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=file&_token={{csrf_token()}}',
        filebrowserWindowWidth: '900',
        filebrowserWindowHeight: '500'
    }
);

</script>

@endpush