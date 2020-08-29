@extends('admin.layout')

@section('main')
@include('admin.component.css_login')
<body class="hold-transition login-page">
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100 main-login">
        <form action="{{ route('admin.login') }}" method="post">
          <div class="col-md-12">
            <img src="{{ asset(sc_store('logo')) }}" alt="logo" class="logo">
          </div>
          <div class="login-title-des col-md-12 p-b-41">
            <a><b>{{sc_config('ADMIN_NAME')}}</b></a>
          </div>
          <div class="col-md-12 form-group has-feedback {!! !$errors->has('username') ?: 'text-red' !!}">
            <div class="wrap-input100 validate-input form-group ">
              <input class="input100 form-control" type="text" placeholder="{{ trans('admin.username') }}"
                name="username" value="{{ old('username') }}">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-user"></i>
              </span>
              @if($errors->has('username'))
              @foreach($errors->get('username') as $message)
              <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
              @endforeach
              @endif
            </div>
          </div>
          <div class="col-md-12 form-group has-feedback {!! !$errors->has('password') ?: 'text-red' !!}">
            <div class="wrap-input100 validate-input form-group ">
              <input class="input100 form-control" type="password" placeholder="{{ trans('admin.password') }}"
                name="password">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock"></i>
              </span>

              @if($errors->has('password'))
              @foreach($errors->get('password') as $message)
              <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
              @endforeach
              @endif
            </div>
          </div>
          <div class="col-md-12">
            <div class="container-login-btn">
              <button class="login-btn" type="submit">
                {{ trans('admin.login') }}
              </button>
            </div>
            {{-- <div class="text-center">
              <a href="" class="forgot">
                <i class="fa fa-caret-right"></i> <b>Forgot Password</b>
              </a>
            </div> --}}

            <div class="checkbox input text-center remember">
              <label>
                <input type="checkbox" name="remember" value="1"
                  {{ (old('remember')) ? 'checked' : '' }}>
                <b>{{ trans('admin.remember_me') }}</b>
              </label>
            </div>

          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>
      </div>
    </div>

    @endsection


    @push('styles')
    <style type="text/css">
      .container-login100 {
        background-image: url({!! asset('images/bg-system.jpg') !!});
      }
    </style>
    @endpush

    @push('scripts')
    <script>
      $(function () {
        $('.input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>
    @endpush