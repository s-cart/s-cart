@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ route('admin_banner.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                        <div class="fields-group">

                            <div class="form-group  row {{ $errors->has('image') ? ' text-red' : '' }}">
                                <label for="image" class="col-sm-2 col-form-label">{{ trans('banner.image') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="image" name="image" value="{{ old('image',$banner['image']??'') }}" class="form-control image" placeholder=""  />
                                        <div class="input-group-append">
                                         <a data-input="image" data-preview="preview_image" data-type="banner" class="btn btn-primary lfm">
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
                                        @if (old('image',$banner['image']??''))
                                        <img src="{{ asset(old('image',$banner['image']??'')) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row {{ $errors->has('url') ? ' text-red' : '' }}">
                                <label for="url" class="col-sm-2 col-form-label">{{ trans('banner.url') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                            </div>
                                        </div>
                                        <input type="text" id="url" name="url" value="{{ old()?old('url'):$banner['url']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('url'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('url') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('target') ? ' text-red' : '' }}">
                                    <label for="target" class="col-sm-2 col-form-label">{{ trans('banner.admin.select_target') }}</label>
                                    <div class="col-sm-8">
                                        <select class="form-control target select2" style="width: 100%;" name="target" >
                                            <option value=""></option>
                                            @foreach ($arrTarget as $k => $v)
                                                <option value="{{ $k }}" {{ (old('target',$banner['target']??'') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                            @endforeach
                                        </select>
                                            @if ($errors->has('target'))
                                                <span class="form-text">
                                                    <i class="fa fa-info-circle"></i> {{ $errors->first('target') }}
                                                </span>
                                            @endif
                                    </div>
                                </div>

                            <div class="form-group row {{ $errors->has('html') ? ' text-red' : '' }}">
                                <label for="html" class="col-sm-2 col-form-label">{{ trans('email_template.html') }}</label>
                                <div class="col-sm-8">
                                        <textarea class="form-control" rows="10" id="html" name="html">{{ old('html',$banner['html']??'') }}</textarea>
                                        @if ($errors->has('html'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('html') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

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


                            @if (!empty($dataType))
                            <div class="form-group row {{ $errors->has('type') ? ' text-red' : '' }}">
                                <label class="col-sm-2 col-form-label">{{ trans('banner.type') }}</label>
                                <div class="col-sm-8">
                                <select class="form-control" name="type">
                                    @foreach ($dataType as $key => $name)
                                    <option {{ (old('type', $banner['type']??'') ==  $key)?'selected':'' }} value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('type'))
                                <span class="form-text">
                                    {{ $errors->first('type') }}
                                </span>
                                @endif
                                </div>
                              </div>
                            @endif


                            <div class="form-group  row {{ $errors->has('sort') ? ' text-red' : '' }}">
                                <label for="sort" class="col-sm-2 col-form-label">{{ trans('banner.sort') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="number" style="width: 100px;" min = 0 id="sort" name="sort" value="{{ old()?old('sort'):$banner['sort']??0 }}" class="form-control sort" placeholder="" />
                                    </div>
                                        @if ($errors->has('sort'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group row ">
                                <label for="status" class="col-sm-2 col-form-label">{{ trans('banner.status') }}</label>
                                <div class="col-sm-8">
                                    <input class="input" type="checkbox" name="status"  {{ old('status',(empty($banner['status'])?0:1))?'checked':''}}>
                                </div>
                            </div>

                    <!-- /.card-body -->

                    <div class="card-footer row">
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
