  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand {{ (Admin::isLoginPage() || Admin::isLogoutPage())?'login-page':'' }} {{ config($styleDefine.'.main-header') }}">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
        @include('admin.component.language')
        @include('admin.component.admin_theme')

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

      @include('admin.component.store_list')

      @include('admin.component.notice')

      @include('admin.component.admin_profile')


      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> --}}

    </ul>
  </nav>
  <!-- /.navbar -->
