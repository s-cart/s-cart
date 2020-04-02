@php
/*
$layout_page = shop_auth
*/
@endphp

@extends($templatePath.'.layout')

@section('main')
<div class="col-md-12 ">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="title-page">{{ $title }}</h2>
        </div>
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

                        <button type="submit" name="SubmitLogin" class="btn btn-default btn-submit pull-right">
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
@endsection

@section('breadcrumb')
<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
    </ol>
</div>
@endsection