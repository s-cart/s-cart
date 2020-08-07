@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ route('admin_store.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->

                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">

                        <div class="card-body">

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
                                class="form-group  row {{ $errors->has('descriptions.'.$code.'.title') ? ' text-red' : '' }}">
                                <label for="{{ $code }}__title"
                                    class="col-sm-2 col-form-label">{{ trans('news.title') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="{{ $code }}__title" name="descriptions[{{ $code }}][title]"
                                            value="{{ old()? old('descriptions.'.$code.'.title'):($descriptions[$code]['title']??'') }}"
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
                                class="form-group  row {{ $errors->has('descriptions.'.$code.'.keyword') ? ' text-red' : '' }}">
                                <label for="{{ $code }}__keyword"
                                    class="col-sm-2 col-form-label">{{ trans('news.keyword') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="{{ $code }}__keyword"
                                            name="descriptions[{{ $code }}][keyword]"
                                            value="{{ old()?old('descriptions.'.$code.'.keyword'):($descriptions[$code]['keyword']??'') }}"
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
                                class="form-group  row {{ $errors->has('descriptions.'.$code.'.description') ? ' text-red' : '' }}">
                                <label for="{{ $code }}__description"
                                    class="col-sm-2 col-form-label">{{ trans('news.description') }} <span class="seo" title="SEO"><i class="fa fa-coffee" aria-hidden="true"></i></span></label>
                                <div class="col-sm-8">
                                        <textarea  id="{{ $code }}__description"
                                            name="descriptions[{{ $code }}][description]"
                                            class="form-control {{ $code.'__description' }}" placeholder="" />{{ old()?old('descriptions.'.$code.'.description'):($descriptions[$code]['description']??'') }}</textarea>
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


                            <div class="form-group  row {{ $errors->has('logo') ? ' text-red' : '' }}">
                                <label for="logo" class="col-sm-2 col-form-label">{{ trans('store.logo') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="logo" name="logo" value="{{ old('logo',$store['logo']??'') }}" class="form-control logo" placeholder=""  />
                                        <div class="input-group-append">
                                         <a data-input="logo" data-preview="preview_image" data-type="logo" class="btn btn-primary lfm">
                                           <i class="fa fa-image"></i> {{trans('product.admin.choose_image')}}
                                         </a>
                                        </div>
                                    </div>
                                        @if ($errors->has('logo'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('logo') }}
                                            </span>
                                        @endif
                                    <div id="preview_image" class="img_holder">
                                        @if (old('logo',$store['logo']??''))
                                        <img src="{{ asset(old('logo',$store['logo']??'')) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('phone') ? ' text-red' : '' }}">
                                <label for="phone" class="col-sm-2 col-form-label">{{ trans('store.phone') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="phone" name="phone" value="{{ old()?old('phone'):$store['phone']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('phone'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('phone') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group  row {{ $errors->has('long_phone') ? ' text-red' : '' }}">
                                <label for="long_phone" class="col-sm-2 col-form-label">{{ trans('store.long_phone') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone-square"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="long_phone" name="long_phone" value="{{ old()?old('long_phone'):$store['long_phone']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('long_phone'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('long_phone') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group  row {{ $errors->has('time_active') ? ' text-red' : '' }}">
                                <label for="time_active" class="col-sm-2 col-form-label">{{ trans('store.time_active') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="time_active" name="time_active" value="{{ old()?old('time_active'):$store['time_active']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('time_active'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('time_active') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('address') ? ' text-red' : '' }}">
                                <label for="address" class="col-sm-2 col-form-label">{{ trans('store.address') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marked"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="address" name="address" value="{{ old()?old('address'):$store['address']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('address'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('address') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('office') ? ' text-red' : '' }}">
                                <label for="office" class="col-sm-2 col-form-label">{{ trans('store.office') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-location-arrow"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="office" name="office" value="{{ old()?old('office'):$store['office']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('office'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('office') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('warehouse') ? ' text-red' : '' }}">
                                <label for="warehouse" class="col-sm-2 col-form-label">{{ trans('store.warehouse') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="warehouse" name="warehouse" value="{{ old()?old('warehouse'):$store['warehouse']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('warehouse'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('warehouse') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('email') ? ' text-red' : '' }}">
                                <label for="email" class="col-sm-2 col-form-label">{{ trans('store.email') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="email" name="email" value="{{ old()?old('email'):$store['email']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('email'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('domain') ? ' text-red' : '' }}">
                                <label for="domain" class="col-sm-2 col-form-label">{{ trans('store.domain') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="domain" name="domain" value="{{ old()?old('domain'):$store['domain']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('domain'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('domain') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="status" class="col-sm-2 col-form-label">{{ trans('store.status') }}</label>
                                <div class="col-sm-8">
                                    <input class="input" type="checkbox" name="status"  {{ old('status',(empty($store['status'])?0:1))?'checked':''}}>
                                </div>
                            </div>
                        </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
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
