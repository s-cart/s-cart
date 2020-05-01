@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_currency.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-sm-2 col-form-label">{{ trans('currency.name') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="name" name="name" value="{!! old()?old('name'):$currency['name']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('code') ? ' has-error' : '' }}">
                                <label for="code" class="col-sm-2 col-form-label">{{ trans('currency.code') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        @if (!empty($currency['code']) && in_array($currency['code'], ['VND','USD']))
                                        <input type="hidden" id="code" name="code" value="{!! $currency['code'] !!}" placeholder="" />
                                        <input type="text" disabled="disabled" value="{!! $currency['code'] !!}" class="form-control" placeholder="" />
                                        @else
                                        <input type="text" id="code" name="code" value="{!! old()?old('code'):$currency['code']??'' !!}" class="form-control" placeholder="" />
                                        @endif

                                    </div>
                                        @if ($errors->has('code'))
                                            <span class="help-block">
                                                {{ $errors->first('code') }}
                                            </span>
                                        @endif
                                </div>
                            </div>



                            <div class="form-group   {{ $errors->has('symbol') ? ' has-error' : '' }}">
                                <label for="symbol" class="col-sm-2 col-form-label">{{ trans('currency.symbol') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="symbol" name="symbol" value="{!! old()?old('symbol'):$currency['symbol']??'' !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('symbol'))
                                            <span class="help-block">
                                                {{ $errors->first('symbol') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('exchange_rate') ? ' has-error' : '' }}">
                                <label for="exchange_rate" class="col-sm-2 col-form-label">{{ trans('currency.exchange_rate') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="number" step="0.01" id="exchange_rate" name="exchange_rate" value="{!! old()?old('exchange_rate'):$currency['exchange_rate']??1 !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('exchange_rate'))
                                            <span class="help-block">
                                                {{ $errors->first('exchange_rate') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('precision') ? ' has-error' : '' }}">
                                <label for="precision" class="col-sm-2 col-form-label">{{ trans('currency.precision') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="number" id="precision" name="precision" type="" value="{!! old()?old('precision'):$currency['precision']??0 !!}" class="form-control" placeholder="" min = 0 />
                                    </div>
                                        @if ($errors->has('precision'))
                                            <span class="help-block">
                                                {{ $errors->first('precision') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  {{ $errors->has('symbol_first') ? ' has-error' : '' }}">
                                <label for="symbol_first" class="col-sm-2 col-form-label">{{ trans('currency.symbol_first') }}</label>
                                <div class="col-sm-8">
                                    <label class="radio-inline"><input type="radio" name="symbol_first" value="1" {!! (old('symbol_first',$currency['symbol_first']??1) =='1')?'checked':'' !!}>Yes</label>
                                    <label class="radio-inline"><input type="radio" name="symbol_first" value="0" {!! (old('symbol_first',$currency['symbol_first']??0) =='0')?'checked':'' !!}>No</label>
                                        @if ($errors->has('symbol_first'))
                                            <span class="help-block">
                                                {{ $errors->first('symbol_first') }}
                                            </span>
                                        @endif
                                </div>
                            </div>


                            <div class="form-group   {{ $errors->has('thousands') ? ' has-error' : '' }}">
                                <label for="thousands" class="col-sm-2 col-form-label">{{ trans('currency.thousands') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text" id="thousands" name="thousands" type="text" value="{!! old('thousands',$currency['thousands']??',') !!}" class="form-control" placeholder="" />
                                    </div>
                                        @if ($errors->has('thousands'))
                                            <span class="help-block">
                                                {{ $errors->first('thousands') }}
                                            </span>
                                        @endif
                                </div>
                            </div>

                            <div class="form-group   {{ $errors->has('sort') ? ' has-error' : '' }}">
                                <label for="sort" class="col-sm-2 col-form-label">{{ trans('currency.sort') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="number" style="width: 100px;" min = 0 id="sort" name="sort" value="{!! old('sort',$currency['sort']??0) !!}" class="form-control sort" placeholder="" />
                                    </div>
                                        @if ($errors->has('sort'))
                                            <span class="help-block">
                                                {{ $errors->first('sort') }}
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
