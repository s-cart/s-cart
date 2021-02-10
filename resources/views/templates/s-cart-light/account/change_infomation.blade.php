@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
- $countries
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-3">
            @include($sc_templatePath.'.account.nav_customer')
        </div>
        <div class="col-12 col-sm-12 col-md-9">
            <h6 class="aside-title">{{ $title }}</h6>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ sc_route('customer.post_change_infomation') }}">
                        @csrf
                        @if (sc_config('customer_lastname'))
                        <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.first_name') }}</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" 
                                    value="{{ (old('first_name'))?old('first_name'):$customer['first_name']}}">

                                @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.last_name') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" 
                                    value="{{ (old('last_name'))?old('last_name'):$customer['last_name']}}">

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
                                <input id="first_name" type="text" class="form-control" name="first_name" 
                                    value="{{ (old('first_name'))?old('first_name'):$customer['first_name']}}">

                                @if($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif

                        @if (sc_config('customer_name_kana'))
                        <div class="form-group row {{ $errors->has('first_name_kana') ? ' has-error' : '' }}">
                            <label for="first_name_kana"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.first_name_kana') }}</label>

                            <div class="col-md-6">
                                <input id="first_name_kana" type="text" class="form-control" name="first_name_kana" 
                                    value="{{ (old('first_name_kana'))?old('first_name_kana'):$customer['first_name_kana']}}">

                                @if($errors->has('first_name_kana'))
                                <span class="help-block">{{ $errors->first('first_name_kana') }}</span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('last_name_kana') ? ' has-error' : '' }}">
                            <label for="last_name_kana"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.last_name_kana') }}</label>

                            <div class="col-md-6">
                                <input id="last_name_kana" type="text" class="form-control" name="last_name_kana" 
                                    value="{{ (old('last_name_kana'))?old('last_name_kana'):$customer['last_name_kana']}}">

                                @if($errors->has('last_name_kana'))
                                <span class="help-block">{{ $errors->first('last_name_kana') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif


                        @if (sc_config('customer_phone'))
                        <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" 
                                    value="{{ (old('phone'))?old('phone'):$customer['phone']}}">

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
                                <input id="postcode" type="text" class="form-control" name="postcode" 
                                    value="{{ (old('postcode'))?old('postcode'):$customer['postcode']}}">

                                @if($errors->has('postcode'))
                                <span class="help-block">{{ $errors->first('postcode') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif

                        <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.email') }}</label>

                            <div class="col-md-6">
                                {{ $customer['email'] }}

                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                            <label for="address1"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.address1') }}</label>

                            <div class="col-md-6">
                                <input id="address1" type="text" class="form-control" name="address1" 
                                    value="{{ (old('address1'))?old('address1'):$customer['address1']}}">

                                @if($errors->has('address1'))
                                <span class="help-block">{{ $errors->first('address1') }}</span>
                                @endif

                            </div>
                        </div>


                        @if (sc_config('customer_address2'))
                        <div class="form-group row {{ $errors->has('address2') ? ' has-error' : '' }}">
                            <label for="address2"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.address2') }}</label>
                            <div class="col-md-6">
                                <input id="address2" type="text" class="form-control" name="address2" 
                                    value="{{ (old('address2'))?old('address2'):$customer['address2']}}">

                                @if($errors->has('address2'))
                                <span class="help-block">{{ $errors->first('address2') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif


                        @if (sc_config('customer_address3'))
                        <div class="form-group row {{ $errors->has('address3') ? ' has-error' : '' }}">
                            <label for="address3"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.address3') }}</label>
                            <div class="col-md-6">
                                <input id="address3" type="text" class="form-control" name="address3" 
                                    value="{{ (old('address3'))?old('address3'):$customer['address3']}}">

                                @if($errors->has('address3'))
                                <span class="help-block">{{ $errors->first('address3') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif

                        @if (sc_config('customer_country'))
                        @php
                        $country = (old('country'))?old('country'):$customer['country'];
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


                        @if (sc_config('customer_sex'))
                        @php
                        $sex = old('sex')?old('sex'):$customer['sex'];
                        @endphp
                        <div class="form-group row {{ $errors->has('sex') ? ' has-error' : '' }}">
                            <label for="sex"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.sex') }}</label>

                            <div class="col-md-6">
                                <label class="radio-inline"><input value="0" type="radio" name="sex"
                                    {{ ($sex == 0)?'checked':'' }}> {{ trans('account.sex_women') }}</label>
                            <label class="radio-inline"><input value="1" type="radio" name="sex"
                                    {{ ($sex == 1)?'checked':'' }}> {{ trans('account.sex_men') }}</label>

                                @if($errors->has('sex'))
                                <span class="help-block">{{ $errors->first('sex') }}</span>
                                @endif

                            </div>
                        </div>
                        @endif

                        @if (sc_config('customer_birthday'))
                        <div class="form-group row {{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <label for="birthday"
                                class="col-md-4 col-form-label text-md-right">{{ trans('account.birthday') }}</label>

                            <div class="col-md-6">
                                <input type="date" id="birthday" data-date-format="YYYY-MM-DD" class="form-control"
                                    name="birthday" 
                                    value="{{ (old('birthday'))?old('birthday'):$customer['birthday']}}">

                                @if($errors->has('birthday'))
                                <span class="help-block">{{ $errors->first('birthday') }}</span>
                                @endif

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
</section>
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
            <li><a href="{{ sc_route('customer.index') }}">{{ trans('front.my_account') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}