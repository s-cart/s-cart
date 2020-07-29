@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ route('admin_currency.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('name') ? ' text-red' : '' }}">
                                <label for="name" class="col-sm-2 col-form-label">{{ trans('currency.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        <input type="text" id="name" name="name" value="{!! old()?old('name'):$currency['name']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('code') ? ' text-red' : '' }}">
                                <label for="code" class="col-sm-2 col-form-label">{{ trans('currency.code') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        @if (!empty($currency['code']) && in_array($currency['code'], ['VND','USD']))
                                        <input type="hidden" id="code" name="code" value="{!! $currency['code'] !!}" placeholder="" />
                                        <input type="text" disabled="disabled" value="{!! $currency['code'] !!}" class="form-control" placeholder="" />
                                        @else
                                        <input type="text" id="code" name="code" value="{!! old()?old('code'):$currency['code']??'' !!}" class="form-control" placeholder="" />
                                        @endif

                                    </div>
                                        @if ($errors->has('code'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('code') }}
                                            </span>
                                        @endif
                                </div>
                            </div>



                            <div class="form-group   {{ $errors->has('symbol') ? ' text-red' : '' }}">
                                <label for="symbol" class="col-sm-2 col-form-label">{{ trans('currency.symbol') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        <input type="text" id="symbol" name="symbol" value="{!! old()?old('symbol'):$currency['symbol']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('symbol'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('symbol') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('exchange_rate') ? ' text-red' : '' }}">
                                <label for="exchange_rate" class="col-sm-2 col-form-label">{{ trans('currency.exchange_rate') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        <input type="number" step="0.01" id="exchange_rate" name="exchange_rate" value="{!! old()?old('exchange_rate'):$currency['exchange_rate']??1 !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('exchange_rate'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('exchange_rate') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('precision') ? ' text-red' : '' }}">
                                <label for="precision" class="col-sm-2 col-form-label">{{ trans('currency.precision') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        <input type="number" id="precision" name="precision" type="" value="{!! old()?old('precision'):$currency['precision']??0 !!}" class="form-control" placeholder="" min = 0 />
                                    </div>
                                        @if ($errors->has('precision'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('precision') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  {{ $errors->has('symbol_first') ? ' text-red' : '' }}">
                                <label for="symbol_first" class="col-sm-2 col-form-label">{{ trans('currency.symbol_first') }}</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline"><input type="radio" name="symbol_first" value="1" {!! (old('symbol_first',$currency['symbol_first']??1) =='1')?'checked':'' !!}>Yes</label>
                                    <label class="radio-inline"><input type="radio" name="symbol_first" value="0" {!! (old('symbol_first',$currency['symbol_first']??0) =='0')?'checked':'' !!}>No</label>
                                        @if ($errors->has('symbol_first'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('symbol_first') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group   {{ $errors->has('thousands') ? ' text-red' : '' }}">
                                <label for="thousands" class="col-sm-2 col-form-label">{{ trans('currency.thousands') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        <input type="text" id="thousands" name="thousands" type="text" value="{!! old('thousands',$currency['thousands']??',') !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('thousands'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('thousands') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('sort') ? ' text-red' : '' }}">
                                <label for="sort" class="col-sm-2 col-form-label">{{ trans('currency.sort') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                                        <input type="number" style="width: 100px;" min = 0 id="sort" name="sort" value="{!! old('sort',$currency['sort']??0) !!}" class="form-control sort" placeholder="" />
                                    </div>
                                        @if ($errors->has('sort'))
                                            <span class="help-block">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('sort') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group  ">
                                <label for="status" class="col-sm-2 col-form-label">{{ trans('currency.status') }}</label>
                                <div class="col-sm-8">
                                    <input class="input" type="checkbox" name="status"  {!! old('status',(empty($currency['status'])?0:1))?'checked':''!!}>

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
