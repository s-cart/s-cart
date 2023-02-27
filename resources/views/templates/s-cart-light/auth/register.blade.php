@extends($sc_templatePath.'.layout')

@section('block_main')
<!--form-->
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
    <div class="row">
        <div class="col-12 col-sm-12">
            <h2>{{ sc_language_render('customer.title_register') }}</h2>
            <form action="{{sc_route('postRegister')}}" method="post" class="box" id="sc_form-process">
                {!! csrf_field() !!}
                <div class="form_content" id="collapseExample">
            
                    @if (sc_config('customer_lastname'))
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('first_name'))?"input-error":"" }}"
                            name="first_name" placeholder="{{ sc_language_render('customer.first_name') }}"
                            value="{{ old('first_name') }}">
                        @if ($errors->has('first_name'))
                        <span class="help-block">
                            {{ $errors->first('first_name') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('last_name'))?"input-error":"" }}"
                            name="last_name" placeholder="{{ sc_language_render('customer.last_name') }}" value="{{ old('last_name') }}">
                        @if ($errors->has('last_name'))
                        <span class="help-block">
                            {{ $errors->first('last_name') }}
                        </span>
                        @endif
                    </div>
                    @else
                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('first_name'))?"input-error":"" }}"
                            name="first_name" placeholder="{{ sc_language_render('customer.name') }}" value="{{ old('first_name') }}">
                        @if ($errors->has('first_name'))
                        <span class="help-block">
                            {{ $errors->first('first_name') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_name_kana'))
                    <div class="form-group{{ $errors->has('first_name_kana') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('first_name_kana'))?"input-error":"" }}"
                            name="first_name_kana" placeholder="{{ sc_language_render('customer.first_name_kana') }}"
                            value="{{ old('first_name_kana') }}">
                        @if ($errors->has('first_name_kana'))
                        <span class="help-block">
                            {{ $errors->first('first_name_kana') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('last_name_kana') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('last_name_kana'))?"input-error":"" }}"
                            name="last_name_kana" placeholder="{{ sc_language_render('customer.last_name_kana') }}" value="{{ old('last_name_kana') }}">
                        @if ($errors->has('last_name_kana'))
                        <span class="help-block">
                            {{ $errors->first('last_name_kana') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('email'))?"input-error":"" }}"
                            name="email" placeholder="{{ sc_language_render('customer.email') }}" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                        <span class="help-block">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                    </div>
            
                    @if (sc_config('customer_phone'))
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('phone'))?"input-error":"" }}"
                            name="phone" placeholder="{{ sc_language_render('customer.phone') }}" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                        <span class="help-block">
                            {{ $errors->first('phone') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_postcode'))
                    <div class="form-group{{ $errors->has('postcode') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('postcode'))?"input-error":"" }}"
                            name="postcode" placeholder="{{ sc_language_render('customer.postcode') }}" value="{{ old('postcode') }}">
                        @if ($errors->has('postcode'))
                        <span class="help-block">
                            {{ $errors->first('postcode') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('address1'))?"input-error":"" }}"
                            name="address1" placeholder="{{ sc_language_render('customer.address1') }}" value="{{ old('address1') }}">
                        @if ($errors->has('address1'))
                        <span class="help-block">
                            {{ $errors->first('address1') }}
                        </span>
                        @endif
                    </div>

                    @if (sc_config('customer_address2'))
                    <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('address2'))?"input-error":"" }}"
                            name="address2" placeholder="{{ sc_language_render('customer.address2') }}" value="{{ old('address2') }}">
                        @if ($errors->has('address2'))
                        <span class="help-block">
                            {{ $errors->first('address2') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_address3'))
                    <div class="form-group{{ $errors->has('address3') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('address3'))?"input-error":"" }}"
                            name="address3" placeholder="{{ sc_language_render('customer.address3') }}" value="{{ old('address3') }}">
                        @if ($errors->has('address3'))
                        <span class="help-block">
                            {{ $errors->first('address3') }}
                        </span>
                        @endif
                    </div>
                    @endif

                    @if (sc_config('customer_company'))
                    <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('company'))?"input-error":"" }}"
                            name="company" placeholder="{{ sc_language_render('customer.company') }}" value="{{ old('company') }}">
                        @if ($errors->has('company'))
                        <span class="help-block">
                            {{ $errors->first('company') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_country'))
                    <div class="form-group  {{ $errors->has('country') ? ' has-error' : '' }}">
                        <select class="form-control country" style="width: 100%;" name="country">
                            <option>__{{ sc_language_render('customer.country') }}__</option>
                            @foreach ($countries as $k => $v)
                            <option value="{{ $k }}" {{ (old('country') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                        <span class="help-block">
                            {{ $errors->first('country') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_sex'))
                    <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                        <label
                            class="validate account_input {{ ($errors->has('sex'))?"input-error":"" }}">{{ sc_language_render('customer.sex') }}:
                        </label>
                        <label class="radio-inline"><input value="0" type="radio" name="sex"
                                {{ (old('sex') == 0)?'checked':'' }}> {{ sc_language_render('customer.sex_women') }}</label>
                        <label class="radio-inline"><input value="1" type="radio" name="sex"
                                {{ (old('sex') == 1)?'checked':'' }}> {{ sc_language_render('customer.sex_men') }}</label>
                        @if ($errors->has('sex'))
                        <span class="help-block">
                            {{ $errors->first('sex') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_birthday'))
                    <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <input type="date"
                            class="is_required validate account_input form-control {{ ($errors->has('birthday'))?"input-error":"" }}"
                            name="birthday" data-date-format="YYYY-MM-DD" placeholder="{{ sc_language_render('customer.birthday') }}"
                            value="{{ old('birthday','2015-08-09') }}">
                        @if ($errors->has('birthday'))
                        <span class="help-block">
                            {{ $errors->first('birthday') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                    @if (sc_config('customer_group'))
                    <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                        <input type="text"
                            class="is_required validate account_input form-control {{ ($errors->has('group'))?"input-error":"" }}"
                            name="group" placeholder="{{ sc_language_render('customer.group') }}" value="{{ old('group') }}">
                        @if ($errors->has('group'))
                        <span class="help-block">
                            {{ $errors->first('group') }}
                        </span>
                        @endif
                    </div>
                    @endif
            
                {{-- Custom fields --}}
                @php
                    $customFields = isset($customFields) ? $customFields : [];
                    $fields = [];
                @endphp
                @php
                    sc_check_view($sc_templatePath.'.common.render_form');
                @endphp
                @include($sc_templatePath.'.common.render_form', ['customFields' => $customFields, 'fields' => $fields])
                {{-- //Custom fields --}}


                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password"
                            class="is_required validate account_input form-control {{ ($errors->has('password'))?"input-error":"" }}"
                            name="password" placeholder="{{ sc_language_render('customer.password') }}" value="">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            {{ $errors->first('password') }}
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input type="password"
                            class="is_required validate account_input form-control {{ ($errors->has('password_confirmation'))?"input-error":"" }}"
                            placeholder="{{ sc_language_render('customer.password_confirm') }}" name="password_confirmation" value="">
                        @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            {{ $errors->first('password_confirmation') }}
                        </span>
                        @endif
                    </div>
                    {!! $viewCaptcha ?? ''!!}
                    <div class="submit">
                        @php
                        $dataButton = [
                                'class' => '', 
                                'id' =>  'sc_button-form-process',
                                'type_w' => '',
                                'type_t' => 'buy',
                                'type_a' => '',
                                'type' => 'submit',
                                'name' => ''.sc_language_render('customer.signup'),
                                'html' => 'name="SubmitCreate"'
                            ];
                        @endphp
                        @include($sc_templatePath.'.common.button.button', $dataButton)

                    </div>
                </div>
            
            </form>
        </div>
    </div>
</div>
</section>
<!--/form-->
@endsection