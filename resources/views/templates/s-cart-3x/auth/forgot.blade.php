@php
/*
$layout_page = shop_auth
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
        <div class="col-md-12 ">
            <div class="row">
                <div class="col-md-6 login-form">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label"><i class="fas fa-envelope"></i>
                                {{ trans('customer.email') }}</label>
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    required>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                <br />
                                @endif

                                <button type="submit" name="SubmitLogin" class="button button-lg button-secondary pull-right">
                                    <span>
                                        <i class="glyphicon glyphicon-wrench"></i>
                                        {{ trans('front.submit_form') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
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
            <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}
