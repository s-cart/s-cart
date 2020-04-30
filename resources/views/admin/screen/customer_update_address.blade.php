@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-sm-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_customer.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            @if (sc_config('customer_lastname'))
                            <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.first_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="first_name" type="text" class="form-control" name="first_name" required
                                        value="{{ (old('first_name', $address['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.last_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="last_name" type="text" class="form-control" name="last_name" required
                                        value="{{ (old('last_name', $address['last_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('last_name'))
                                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="first_name" type="text" class="form-control" name="first_name" required
                                        value="{{ (old('first_name', $address['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config('customer_phone'))
                            <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.phone') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="phone" type="text" class="form-control" name="phone" required
                                        value="{{ (old('phone', $address['phone'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('phone'))
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config('customer_postcode'))
                            <div class="form-group row {{ $errors->has('postcode') ? ' has-error' : '' }}">
                                <label for="postcode"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.postcode') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="postcode" type="text" class="form-control" name="postcode" required
                                        value="{{ (old('postcode', $address['postcode'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('postcode'))
                                    <span class="help-block">{{ $errors->first('postcode') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config('customer_address2'))
                            <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                                <label for="address1"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.address1') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="address1" type="text" class="form-control" name="address1" required
                                        value="{{ (old('address1', $address['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address1'))
                                    <span class="help-block">{{ $errors->first('address1') }}</span>
                                    @endif
    
                                </div>
                            </div>
    
                            <div class="form-group row {{ $errors->has('address2') ? ' has-error' : '' }}">
                                <label for="address2"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.address2') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="address2" type="text" class="form-control" name="address2" required
                                        value="{{ (old('address2', $address['address2'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address2'))
                                    <span class="help-block">{{ $errors->first('address2') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                                <label for="address1"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.address') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="address1" type="text" class="form-control" name="address1" required
                                        value="{{ (old('address1', $address['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address1'))
                                    <span class="help-block">{{ $errors->first('address1') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config('customer_country'))
                            @php
                            $country = old('country', $address['country'] ?? '');
                            @endphp
    
                            <div class="form-group row {{ $errors->has('country') ? ' has-error' : '' }}">
                                <label for="country"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control country" style="width: 100%;" name="country">
                                        <option>__{{ trans('account.country') }}__</option>
                                        @foreach ($countries as $k => $v)
                                        <option value="{{ $k }}" {{ ($country == $k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                    <span class="help-block">
                                        {{ $errors->first('country') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($address->id != $customer->address_id)
                            <div class="form-group row">
                                <label for="default"
                                    class="col-md-2 col-form-label text-md-right">{{ trans('account.chose_address_default') }}</label>
                                <div class="col-md-8">
                                    <input id="default" type="checkbox" name="default">
                                </div>
                            </div>
                            @endif


                        </div>
                    </div>



                    <!-- /.box-body -->

                    <div class="box-footer">
                            @csrf
                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-8">
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

@endpush
