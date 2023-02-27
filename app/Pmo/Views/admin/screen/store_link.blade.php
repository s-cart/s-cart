@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ sc_route_admin('admin_store_link.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                            <div class="form-group row {{ $errors->has('name') ? ' text-red' : '' }}">
                                <label for="name" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="name" name="name" value="{{ old()?old('name'):$link['name']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

@if ($layout !='collection')
                            <div class="form-group row {{ $errors->has('url') ? ' text-red' : '' }}">
                                <label for="url" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.url') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text" id="url" name="url" value="{{ old()?old('url'):$link['url']??'' }}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('url'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('url') }}
                                            </span>
                                        @else
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ sc_language_render('admin.link.helper_url') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group row {{ $errors->has('target') ? ' text-red' : '' }}">
                                <label for="target" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.select_target') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control target select2" style="width: 100%;" name="target" >
                                        <option value=""></option>
                                        @foreach ($arrTarget as $k => $v)
                                            <option value="{{ $k }}" {{ (old('target',$link['target']??'') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('target'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('target') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('collection_id') ? ' text-red' : '' }}">
                                <label for="group" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.select_collection') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control collection select2" name="collection_id" >
                                        <option value="">----</option>
                                        @foreach ($arrCollection as $k => $v)
                                            <option value="{{ $k }}" {{ (old('collection_id',$link['collection_id']??'') ==$k) ? 'selected':'' }}>{{ $v." (ID: ".$k.")" }}</option>
                                        @endforeach
                                    </select>
                                        @if ($errors->has('collection_id'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('collection_id') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
@endif

                            <div class="form-group row {{ $errors->has('group') ? ' text-red' : '' }}">
                                <label for="group" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.select_group') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <select class="form-control group select2" name="group" >
                                        <option value=""></option>
                                        @foreach ($arrGroup as $k => $v)
                                            <option value="{{ $k }}" {{ (old('group',$link['group']??'') ==$k) ? 'selected':'' }}>{{ $v." (Code: ".$k.")" }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <a href="{{ sc_route_admin('admin_store_link_group.index') }}" class="btn  btn-flat" title="New">
                                            <i class="fa fa-plus" title="{{ sc_language_render('action.add') }}"></i>
                                         </a>
                                    </div>
                                        @if ($errors->has('group'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('group') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row {{ $errors->has('sort') ? ' text-red' : '' }}">
                                <label for="sort" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.sort') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="number" style="width: 100px;" min = 0 id="sort" name="sort" value="{!! old()?old('sort'):$link['sort']??0 !!}" class="form-control sort" placeholder="" />
                                    </div>
                                        @if ($errors->has('sort'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

@if (sc_check_multi_shop_installed())
                            {{-- select shop_store --}}
                            @php
                            $listStore = [];
                            if (function_exists('sc_get_list_store_of_link_detail')) {
                                $oldData = sc_get_list_store_of_link_detail($link['id'] ?? '');
                            } else {
                                $oldData = null;
                            }
                            $shop_store = old('shop_store', $oldData);
                            if(is_array($shop_store)){
                                foreach($shop_store as $value){
                                    $listStore[] = $value;
                                }
                            }
                            @endphp
                  
                            <div class="form-group row {{ $errors->has('shop_store') ? ' text-red' : '' }}">
                                <label for="shop_store"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('admin.select_store') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control shop_store select2" 
                                    @if (sc_check_multi_store_installed())
                                        multiple="multiple"
                                    @endif
                                    data-placeholder="{{ sc_language_render('admin.select_store') }}" style="width: 100%;"
                                    name="shop_store[]">
                                        <option value=""></option>
                                        @foreach (sc_get_list_code_store() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ (count($listStore) && in_array($k, $listStore))?'selected':'' }}>{{ $v }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('shop_store'))
                                    <span class="form-text">
                                        <i class="fa fa-info-circle"></i> {{ $errors->first('shop_store') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            {{-- //select shop_store --}}
@endif

                            <div class="form-group row ">
                                <label for="status" class="col-sm-2 col-form-label">{{ sc_language_render('admin.link.status') }}</label>
                                <div class="col-sm-8">
                                <input class="checkbox" type="checkbox" name="status"  {{ old('status',(empty($link['status'])?0:1))?'checked':''}}>

                                </div>
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
@endpush
