@php
/*
$layout_page = shop_profile
$user
$countries
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-12 col-sm-12 col-md-3">
            @include($sc_templatePath.'.account.nav_customer')
        </div>
        <div class="col-12 col-sm-12 col-md-9">
            <h3 class="title-optoins-customer">{{ $title }}</h3>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ sc_route('member.post_update_address', ['id' => $address->id]) }}">
                        @csrf
                        @if (sc_config('customer_lastname'))
                        <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.first_name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" required
                                    value="{{ (old('first_name'))?old('first_name'):$address['first_name']}}">

                                @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.last_name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" required
                                    value="{{ (old('last_name'))?old('last_name'):$address['last_name']}}">

                                @if($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                                @endif

                            </div>
                        </div>
                        @else
                        <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" required
                                    value="{{ (old('first_name'))?old('first_name'):$address['first_name']}}">

                                @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif


                        @if (sc_config('customer_phone'))
                        <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" required
                                    value="{{ (old('phone'))?old('phone'):$address['phone']}}">

                                @if($errors->has('phone'))
                                <span class="help-block">{{ $errors->first('phone') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif

                        @if (sc_config('customer_postcode'))
                        <div class="form-group row {{ $errors->has('postcode') ? ' has-error' : '' }}">
                            <label for="postcode"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.postcode') }}</label>

                            <div class="col-md-6">
                                <input id="postcode" type="text" class="form-control" name="postcode" required
                                    value="{{ (old('postcode'))?old('postcode'):$address['postcode']}}">

                                @if($errors->has('postcode'))
                                <span class="help-block">{{ $errors->first('postcode') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif


                        @if (sc_config('customer_address2'))
                        <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                            <label for="address1"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.address1') }}</label>

                            <div class="col-md-6">
                                <input id="address1" type="text" class="form-control" name="address1" required
                                    value="{{ (old('address1'))?old('address1'):$address['address1']}}">

                                @if($errors->has('address1'))
                                <span class="help-block">{{ $errors->first('address1') }}</span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('address2') ? ' has-error' : '' }}">
                            <label for="address2"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.address2') }}</label>
                            <div class="col-md-6">
                                <input id="address2" type="text" class="form-control" name="address2" required
                                    value="{{ (old('address2'))?old('address2'):$address['address2']}}">

                                @if($errors->has('address2'))
                                <span class="help-block">{{ $errors->first('address2') }}</span>
                                @endif

                            </div>
                        </div>
                        @else
                        <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                            <label for="address1"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.address') }}</label>

                            <div class="col-md-6">
                                <input id="address1" type="text" class="form-control" name="address1" required
                                    value="{{ (old('address1'))?old('address1'):$address['address1']}}">

                                @if($errors->has('address1'))
                                <span class="help-block">{{ $errors->first('address1') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif


                        @if (sc_config('customer_country'))
                        @php
                        $country = (old('country'))?old('country'):$address['country'];
                        @endphp

                        <div class="form-group row {{ $errors->has('country') ? ' has-error' : '' }}">
                            <label for="country"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.country') }}</label>
                            <div class="col-md-6">
                                <select class="form-control country" style="width: 100%;" name="country">
                                    <option>__{{ trans('account.country') }}__</option>
                                    @foreach ($countries as $k => $v)
                                    <option value="{{ $k }}" {{ ($country ==$k) ? 'selected':'' }}>{{ $v }}</option>
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

                        @if ($address->id != auth()->user()->address_id)
                        <div class="form-group row">
                            <label for="default"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.chose_address_default') }}</label>
                            <div class="col-md-6">
                                <input id="default" type="checkbox" class="form-control" name="default">
                            </div>
                        </div>
                        @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('account.update_infomation') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
            <li><a href="{{ sc_route('member.index') }}">{{ trans('front.my_account') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}