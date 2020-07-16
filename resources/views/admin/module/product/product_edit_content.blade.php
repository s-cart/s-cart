{{-- Descriptions --}}
                                    @php
                                    $descriptions = $product->descriptions->keyBy('lang')->toArray();
                                    @endphp

                                    @foreach ($languages as $code => $language)
                                    @php
                                    $count = 0;
                                    @endphp
                                    <div class="nav-tabs-custom">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#lang_{{ $language->id }}" data-toggle="tab" aria-expanded="true">{!! sc_image_render($language->icon,'20px','20px', $language->name) !!} {{ $language->name }}</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane {{ $count == 0 ? 'active' : '' }}" id="lang_{{ $language->id }}">
                                                <div class="form-group {{ $errors->has('descriptions.'.$code.'.name') ? ' has-error' : '' }}">
                                                    <label for="{{ $code }}__name" class="col-sm-2 col-form-label">{{ trans('product.name') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>

                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                                            <input type="text" id="{{ $code }}__name" name="descriptions[{{ $code }}][name]"
                                                            value="{!!old('descriptions.'.$code.'.name',($descriptions[$code]['name']??'')) !!}"
                                                            class="form-control {{ $code.'__name' }}" placeholder="" />
                                                        </div>
                                                        @if ($errors->has('descriptions.'.$code.'.name'))
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ $errors->first('descriptions.'.$code.'.name') }}
                                                        </span>
                                                        @else
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>200]) }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->has('descriptions.'.$code.'.keyword') ? ' has-error' : '' }}">
                                                    <label for="{{ $code }}__keyword" class="col-sm-2 col-form-label">{{ trans('product.keyword') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                                            <input type="text" id="{{ $code }}__keyword"
                                                            name="descriptions[{{ $code }}][keyword]"
                                                            value="{!! old('descriptions.'.$code.'.keyword',($descriptions[$code]['keyword']??'')) !!}"
                                                            class="form-control {{ $code.'__keyword' }}" placeholder="" />
                                                        </div>
                                                        @if ($errors->has('descriptions.'.$code.'.keyword'))
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ $errors->first('descriptions.'.$code.'.keyword') }}
                                                        </span>
                                                        @else
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>200]) }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group {{ $errors->has('descriptions.'.$code.'.description') ? ' has-error' : '' }}">
                                                    <label for="{{ $code }}__description" class="col-sm-2 col-form-label">{{ trans('product.description') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                                    <div class="col-sm-8">
                                                        <textarea  id="{{ $code }}__description" name="descriptions[{{ $code }}][description]"
                                                        class="form-control {{ $code.'__description' }}" placeholder="" />{{ old('descriptions.'.$code.'.description',($descriptions[$code]['description']??'')) }}</textarea>
                                                        @if ($errors->has('descriptions.'.$code.'.description'))
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ $errors->first('descriptions.'.$code.'.description') }}
                                                        </span>
                                                        @else
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i> {{ trans('admin.max_c',['max'=>300]) }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($product->kind == SC_PRODUCT_SINGLE)
                                                <div class="form-group {{ $errors->has('descriptions.'.$code.'.content') ? ' has-error' : '' }}">
                                                    <label for="{{ $code }}__content" class="col-sm-2 col-form-label">{{ trans('product.content') }}</label>
                                                    <div class="col-sm-8">
                                                        <textarea id="{{ $code }}__content" class="editor" name="descriptions[{{ $code }}][content]">
                                                        {!! old('descriptions.'.$code.'.content',($descriptions[$code]['content']??'')) !!}</textarea>
                                                        @if ($errors->has('descriptions.'.$code.'.content'))
                                                        <span class="help-block">
                                                            <i class="fa fa-info-circle"></i>
                                                            {{ $errors->first('descriptions.'.$code.'.content') }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    $count++;
                                    @endphp
                                    @endforeach
                                    {{-- //Descriptions --}}