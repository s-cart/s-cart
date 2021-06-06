@php
/*
$layout_page = shop_auth
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
    <div class="row">
        <div class="col-12 col-sm-12">
            <h2>{{ sc_language_render('customer.password_forgot') }}</h2>

            <form class="form-horizontal" method="POST" action="{{ sc_route('password.email') }}" id="form-process">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-12 control-label"><i class="fas fa-envelope"></i>
                        {{ sc_language_render('customer.email') }}</label>
                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                            required>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        <br />
                        @endif
                        {!! $viewCaptcha ?? ''!!}
                        <button type="submit" name="SubmitLogin" class="button button-lg button-secondary" id="button-form-process">{{ sc_language_render('action.submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@endsection