  <!-- Navbar -->
@php
  $mode = config('app.debug')?'danger':'primary';
@endphp
  <nav class="main-header navbar navbar-expand  {{ ($styleDefault == 1)?'navbar-dark navbar-lightblue':'' }} {{ (Admin::isLoginPage() || Admin::isLogoutPage())?'login-page':'navbar-'.$mode }}">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
        @include('admin.component.language')

      {{-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
          Style
      </a>
        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-left p-1">
            <a href="{{ route('admin.locale', ['code' => 1]) }}">
              <div class="hover">
              </div>
            </a>
        </div>
      </li> --}}
    </ul>

    @if (\Admin::user()->checkUrlAllowAccess(route('admin_order.index')))
    <!-- SEARCH FORM -->
    <form action="{{ route('admin_order.index') }}" method="get" class="form-inline ml-3 d-none d-sm-block" >
      <div class="input-group input-group-sm">
        <input name="keyword" class="form-control form-control-navbar" type="search" placeholder="{{trans('order.search')}}" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    @endif

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a target="_new" title="Shop Online" class="nav-link"  href="{{ route('home') }}" role="button">
          <i class="fab fa-shopify"></i>
        </a>
      </li>

      @include('admin.component.notice')

      <!-- User Account: style can be found in dropdown.less -->
      <li class="nav-item dropdown user-menu">

        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
          <img src="{{ Admin::user()->avatar?asset(Admin::user()->avatar):asset('admin/avatar/user.jpg') }}" class="user-image" alt="User Image">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <div class="text-center">
            <img src="{{ Admin::user()->avatar?asset(Admin::user()->avatar):asset('admin/avatar/user.jpg') }}" class="img-circle" alt="{{ Admin::user()->name }}">
            <div>
              {{ Admin::user()->name }}<br>
              <small>{{ trans('user.member_since') }} {{ Admin::user()->created_at }}</small>
            </div>
          </div>
          <!-- Menu Footer-->
          <div class="user-footer">
            <div class="float-left">
              <a href="{{ route('admin.setting') }}" class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
            </div>
            <div class="float-right">
              <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
            </div>
          </div>
        </div>
      </li>

      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}

    </ul>
  </nav>
  <!-- /.navbar -->
