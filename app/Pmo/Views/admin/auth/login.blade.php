@extends($templatePathAdmin.'layout_portable')

@section('main')
@include($templatePathAdmin.'component.css_login')
    <div class="container-login100">
      <div class="wrap-login100 main-login">
        <div class="card-header text-center">
          <a href="{{ sc_route('home') }}" class="h1">
            <img src="{{ sc_file(sc_store('logo')) }}" alt="logo" class="logo">
          </a>
        </div>
        <div class="login-title-des col-md-12 p-b-41">
          <a><b>{{sc_language_render('admin.login')}}</b></a>
        </div>
        <form action="{{ sc_route_admin('admin.login') }}" method="post">

          <div class="input-form {!! !$errors->has('email') ?: 'text-red' !!}">
            <div class="col-md-12 form-group has-feedback {!! !$errors->has('username') ?: 'text-red' !!}">
              <div class="wrap-input100 validate-input form-group ">
                <input class="input100 form-control" type="text" placeholder="{{ sc_language_render('admin.user.username') }}"
                  name="username" value="{{ old('username') }}">
                <span class="focus-input100"></span>
                <span class="symbol-input100">
                  <i class="fa fa-user"></i>
                </span>
              </div>
              @if($errors->has('username'))
              @foreach($errors->get('username') as $message)
              <i class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</i><br>
              @endforeach
              @endif
            </div>
          </div>

          <div class="input-form {!! !$errors->has('password') ?: 'text-red' !!}">
            <div class="col-md-12 form-group has-feedback">
              <div class="wrap-input100 validate-input form-group ">
                <input class="input100 form-control" type="password" placeholder="{{ sc_language_render('admin.user.password') }}"
                  name="password">
                <span class="focus-input100"></span>
                <span class="symbol-input100">
                  <i class="fa fa-lock"></i>
                </span>
              </div>
              @if($errors->has('password'))
              @foreach($errors->get('password') as $message)
              <i class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</i>
              @endforeach
              @endif
            </div>
          </div>
          <div class="col-md-12">
            <div class="container-login-btn">
              <button class="login-btn" type="submit">
                {{ sc_language_render('admin.user.login') }}
              </button>
            </div>

            @if (sc_config_global('admin_forgot_password', 1))
            <div class="text-center">
              <a href="{{ sc_route_admin('admin.forgot') }}" class="forgot">
                <i class="fa fa-caret-right"></i> <b>{{ sc_language_render('admin.password_forgot') }}</b>
              </a>
            </div>
            @endif


            <div class="checkbox input text-center remember">
              <label>
                <input class="checkbox" type="checkbox" name="remember" value="1"
                  {{ (old('remember')) ? 'checked' : '' }}>
                <b>{{ sc_language_render('admin.user.remember_me') }}</b>
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
        background-image: url({!! sc_file('images/bg-system.jpg') !!});
      }
    </style>
    @endpush

    @push('scripts')
    <script>
      $(function () {
        $('.checkbox').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' /* optional */
        });
      });
    </script>
    @endpush