@php
    $styleDefine = 'admin.theme_define.'.config('admin.theme_default');
@endphp
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="{{ sc_file('images/icon.png') }}" type="image/png" sizes="16x16">
  <title>{{sc_config_admin('ADMIN_TITLE')}} | {{ $title??'' }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- iCheck -->
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/iCheck/square/blue.css')}}">
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  
  <link rel="stylesheet" href="{{ sc_file('admin/LTE/plugins/jquery-ui/jquery-ui.min.css')}}">

  <link rel="stylesheet" href="{{ sc_file('admin/LTE/dist/css/adminlte.min.css')}}">

  @stack('styles')

</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed {{ config($styleDefine.'.body') }}">

<div class="wrapper">
    @yield('main')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ sc_file('admin/LTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ sc_file('admin/LTE/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
{{-- <script>
  $.widget.bridge('uibutton', $.ui.button)
</script> --}}
<!-- Bootstrap 4 -->
<script src="{{ sc_file('admin/LTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
{{-- <!-- ChartJS -->
<script src="{{ sc_file('admin/LTE/plugins/chart.js/Chart.min.js')}}"></script> --}}
<!-- JQVMap -->
<script src="{{ sc_file('admin/LTE/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ sc_file('admin/LTE/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- daterangepicker -->
{{-- <script src="{{ sc_file('admin/LTE/plugins/moment/moment.min.js')}}"></script>
<script src="{{ sc_file('admin/LTE/plugins/daterangepicker/daterangepicker.js')}}"></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
{{-- <script src="{{ sc_file('admin/LTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script> --}}
<!-- Summernote -->
<script src="{{ sc_file('admin/LTE/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ sc_file('admin/LTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

<script src="{{ sc_file('admin/LTE/plugins/iCheck/icheck.min.js')}}"></script>

@stack('scripts')


<script>
  $(function () {
      $(".date_time").datepicker({
          dateFormat: "yy-mm-dd"
      });
  });
</script>

</body>
</html>