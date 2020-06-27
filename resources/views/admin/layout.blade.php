<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/png" sizes="16x16">
  <title>{{sc_config('ADMIN_TITLE')}} | {{ $title??'' }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}">

@if (!Admin::isLoginPage() && !Admin::isLogoutPage())
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  @include('admin.component.css')
@endif


<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/AdminLTE/bower_components/select2/dist/css/select2.min.css')}}">
{{-- switch --}}
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-switch.min.css')}}">

  @stack('styles')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/dist/css/AdminLTE.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('admin/AdminLTE/plugins/iCheck/square/blue.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
@php
  $mode = (sc_config('APP_DEBUG') === 'on')?'red':'blue';
@endphp
<body class="hold-transition {{ (Admin::isLoginPage() || Admin::isLogoutPage())?'login-page':'skin-'.$mode.' sidebar-mini' }}">
  <div class="wrapper">
  @if ((Admin::isLoginPage() || Admin::isLogoutPage()))
    @yield('main')
  @else
    @include('admin.component.exception')
    @include('admin.header')
    @include('admin.sidebar')
    <div class="content-wrapper">
      <div id="app">
        <section class="content-header">
           <h1>
              <i class="{{ $icon??'' }}" aria-hidden="true"></i> {!! $title??'' !!}
              <small>{!!$subTitle??'' !!}</small>
           </h1>
           <div class="more_info">{!! $more_info??'' !!}</div>
           <!-- breadcrumb start -->
           <ol class="breadcrumb">
              <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> {{ trans('admin.home') }}</a></li>
              <li>{!! $title??'' !!}</li>
           </ol>
           <!-- breadcrumb end -->
        </section>
        <section class="content">
             @yield('main')
         </section>
        </div>
      </div>

    @include('admin.footer')

    <div id="loading">
          <div id="overlay" class="overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw "></i></div>
   </div>

  @endif
  </div>

@section('version-jquery')
<!-- jQuery 3 -->
<script src="{{ asset('admin/AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
@show

<script src="{{ asset('admin/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{ asset('admin/AdminLTE/plugins/iCheck/icheck.min.js')}}"></script>

@if (!Admin::isLoginPage() && !Admin::isLogoutPage())
<script src="{{ asset('admin/AdminLTE/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('admin/AdminLTE/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('admin/AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{ asset('admin/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ asset('admin/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('admin/AdminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('admin/AdminLTE/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('admin/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ asset('admin/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('admin/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ asset('admin/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('admin/AdminLTE/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/AdminLTE/dist/js/adminlte.min.js')}}"></script>
{{-- sweetalert2 --}}
<script src="{{ asset('admin/plugin/sweetalert2.all.min.js')}}"></script>
{{-- <script src="{{ asset('admin/plugin/promise-polyfill.js')}}"></script> --}}

<!-- Select2 -->
<script src="{{ asset('admin/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
{{-- switch --}}
<script src="{{ asset('admin/plugin/bootstrap-switch.min.js')}}"></script>
@endif

@stack('scripts')

@include('admin.component.script')
@include('admin.component.alerts')

</body>
</html>
