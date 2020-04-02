@extends($templatePath.'.layout')

@section('main')
<!--form-->
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="title-page">{{ $title }}</h2>
        </div>
        <div class="col-12 col-sm-12 btn-tab-cs">
            <button class="btn btn-link active btn-tab-login" type="button" data-tab="tab-login">
                {{ trans('account.title_login') }}
            </button>
            <button class="btn btn-link btn-tab-login" type="button" data-tab="tab-signup">
                {{ trans('account.title_register') }}
            </button>
        </div>
        <div class="col-12 col-sm-12">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 active" id="tab-login">
                    <div class="login-form">
                        <!--login form-->
                        @include($templatePath.'.auth.login')
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-12 col-sm-12 col-md-6" id="tab-signup">
                    <div class="signup-form">
                        <!--sign up form-->
                        @include($templatePath.'.auth.register')
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--/form-->
@endsection

@section('breadcrumb')
<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
    </ol>
</div>
@endsection