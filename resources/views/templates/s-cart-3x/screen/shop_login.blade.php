@extends($sc_templatePath.'.layout')

@section('block_main')
<!--form-->
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
    <div class="row">
        <div class="col-12 col-sm-12">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 active" id="tab-login">
                    <div class="login-form">
                        <!--login form-->
                        @include($sc_templatePath.'.auth.login')
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-12 col-sm-12 col-md-6" id="tab-signup">
                    <div class="signup-form">
                        <!--sign up form-->
                        @include($sc_templatePath.'.auth.register')
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<!--/form-->
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}
