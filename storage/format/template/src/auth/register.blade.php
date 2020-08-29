@php
/*
$layout_page = shop_auth
*/ 
@endphp

<h2>{{ trans('account.title_register') }}</h2>
<form action="{{sc_route('postRegister')}}" method="post" class="box">
    {!! csrf_field() !!}
    <div class="form_content {{ (old('check_red'))?'in':'' }}" id="collapseExample">

        @if (sc_config('customer_lastname'))
        <div class="form-group{{ $errors->has('reg_first_name') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_first_name'))?"input-error":"" }}"
                name="reg_first_name" placeholder="{{ trans('account.first_name') }}"
                value="{{ old('reg_first_name') }}">
            @if ($errors->has('reg_first_name'))
            <span class="help-block">
                {{ $errors->first('reg_first_name') }}
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('reg_last_name') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_last_name'))?"input-error":"" }}"
                name="reg_last_name" placeholder="{{ trans('account.last_name') }}" value="{{ old('reg_last_name') }}">
            @if ($errors->has('reg_last_name'))
            <span class="help-block">
                {{ $errors->first('reg_last_name') }}
            </span>
            @endif
        </div>
        @else
        <div class="form-group{{ $errors->has('reg_first_name') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_first_name'))?"input-error":"" }}"
                name="reg_first_name" placeholder="{{ trans('account.name') }}"
                value="{{ old('reg_first_name') }}">
            @if ($errors->has('reg_first_name'))
            <span class="help-block">
                {{ $errors->first('reg_first_name') }}
            </span>
            @endif
        </div>
        @endif


        <div class="form-group{{ $errors->has('reg_email') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_email'))?"input-error":"" }}"
                name="reg_email" placeholder="{{ trans('account.email') }}" value="{{ old('reg_email') }}">
            @if ($errors->has('reg_email'))
            <span class="help-block">
                {{ $errors->first('reg_email') }}
            </span>
            @endif
        </div>

        @if (sc_config('customer_phone'))
        <div class="form-group{{ $errors->has('reg_phone') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_phone'))?"input-error":"" }}"
                name="reg_phone" placeholder="{{ trans('account.phone') }}" value="{{ old('reg_phone') }}">
            @if ($errors->has('reg_phone'))
            <span class="help-block">
                {{ $errors->first('reg_phone') }}
            </span>
            @endif
        </div>
        @endif

        @if (sc_config('customer_postcode'))
        <div class="form-group{{ $errors->has('reg_postcode') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_postcode'))?"input-error":"" }}"
                name="reg_postcode" placeholder="{{ trans('account.postcode') }}" value="{{ old('reg_postcode') }}">
            @if ($errors->has('reg_postcode'))
            <span class="help-block">
                {{ $errors->first('reg_postcode') }}
            </span>
            @endif
        </div>
        @endif

        @if (sc_config('customer_address2'))
        <div class="form-group{{ $errors->has('reg_address1') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_address1'))?"input-error":"" }}"
                name="reg_address1" placeholder="{{ trans('account.address1') }}" value="{{ old('reg_address1') }}">
            @if ($errors->has('reg_address1'))
            <span class="help-block">
                {{ $errors->first('reg_address1') }}
            </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('reg_address2') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_address2'))?"input-error":"" }}"
                name="reg_address2" placeholder="{{ trans('account.address2') }}" value="{{ old('reg_address2') }}">
            @if ($errors->has('reg_address2'))
            <span class="help-block">
                {{ $errors->first('reg_address2') }}
            </span>
            @endif
        </div>
        @else
        <div class="form-group{{ $errors->has('reg_address1') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_address1'))?"input-error":"" }}"
                name="reg_address1" placeholder="{{ trans('account.address') }}" value="{{ old('reg_address1') }}">
            @if ($errors->has('reg_address1'))
            <span class="help-block">
                {{ $errors->first('reg_address1') }}
            </span>
            @endif
        </div>
        @endif


        @if (sc_config('customer_company'))
        <div class="form-group{{ $errors->has('reg_company') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_company'))?"input-error":"" }}"
                name="reg_company" placeholder="{{ trans('account.company') }}" value="{{ old('reg_company') }}">
            @if ($errors->has('reg_company'))
            <span class="help-block">
                {{ $errors->first('reg_company') }}
            </span>
            @endif
        </div>
        @endif

        @if (sc_config('customer_country'))
        <div class="form-group  {{ $errors->has('reg_country') ? ' has-error' : '' }}">
            <select class="form-control reg_country" style="width: 100%;" name="reg_country">
                <option>__{{ trans('account.country') }}__</option>
                @foreach ($countries as $k => $v)
                <option value="{{ $k }}" {{ (old('reg_country') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
            @if ($errors->has('reg_country'))
            <span class="help-block">
                {{ $errors->first('reg_country') }}
            </span>
            @endif
        </div>
        @endif

        @if (sc_config('customer_sex'))
        <div class="form-group{{ $errors->has('reg_sex') ? ' has-error' : '' }}">
            <label class="validate account_input {{ ($errors->has('reg_sex'))?"input-error":"" }}">{{ trans('account.sex') }}: </label>
            <label class="radio-inline"><input value="0" type="radio" name="reg_sex" {{ (old('reg_sex') == 0)?'checked':'' }}> {{ trans('account.sex_women') }}</label>
            <label class="radio-inline"><input value="1" type="radio" name="reg_sex" {{ (old('reg_sex') == 1)?'checked':'' }}> {{ trans('account.sex_men') }}</label>
            @if ($errors->has('reg_sex'))
            <span class="help-block">
                {{ $errors->first('reg_sex') }}
            </span>
            @endif
        </div>
        @endif

        @if (sc_config('customer_birthday'))
        <div class="form-group{{ $errors->has('reg_birthday') ? ' has-error' : '' }}">
            <input type="date"
                class="is_required validate account_input form-control {{ ($errors->has('reg_birthday'))?"input-error":"" }}"
                name="reg_birthday" data-date-format="YYYY-MM-DD"  placeholder="{{ trans('account.birthday') }}" value="{{ old('reg_birthday','2015-08-09') }}">
            @if ($errors->has('reg_birthday'))
            <span class="help-block">
                {{ $errors->first('reg_birthday') }}
            </span>
            @endif
        </div>
        @endif

        @if (sc_config('customer_group'))
        <div class="form-group{{ $errors->has('reg_group') ? ' has-error' : '' }}">
            <input type="text"
                class="is_required validate account_input form-control {{ ($errors->has('reg_group'))?"input-error":"" }}"
                name="reg_group" placeholder="{{ trans('account.group') }}" value="{{ old('reg_group') }}">
            @if ($errors->has('reg_group'))
            <span class="help-block">
                {{ $errors->first('reg_group') }}
            </span>
            @endif
        </div>
        @endif

        <div class="form-group{{ $errors->has('reg_password') ? ' has-error' : '' }}">
            <input type="password"
                class="is_required validate account_input form-control {{ ($errors->has('reg_password'))?"input-error":"" }}"
                name="reg_password" placeholder="{{ trans('account.password') }}" value="">
            @if ($errors->has('reg_password'))
            <span class="help-block">
                {{ $errors->first('reg_password') }}
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('reg_password_confirmation') ? ' has-error' : '' }}">
            <input type="password"
                class="is_required validate account_input form-control {{ ($errors->has('reg_password_confirmation'))?"input-error":"" }}"
                placeholder="{{ trans('account.password_confirm') }}" name="reg_password_confirmation" value="">
            @if ($errors->has('reg_password_confirmation'))
            <span class="help-block">
                {{ $errors->first('reg_password_confirmation') }}
            </span>
            @endif
        </div>
        <input type="hidden" name="check_red" value="1">
        <div class="submit">
            <button type="submit" name="SubmitCreate" class="btn btn-default">{{ trans('account.signup') }}</button>
        </div>
    </div>

</form>