   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-light-pink elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link navbar-secondary">
      S-Cart
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar {{ config($styleDefine.'.sidebar') }}">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ Admin::user()->avatar?asset(Admin::user()->avatar):asset('admin/avatar/user.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Admin::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" >

          @if (\Admin::user()->checkUrlAllowAccess(route('admin_order.index')))
          <!-- SEARCH FORM -->
          <form action="{{ route('admin_order.index') }}" method="get" class="form-inline m-1 d-block d-sm-none" >
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

        @php
          $menus = Admin::getMenuVisible();
        @endphp

@if (count($menus))
{{-- Level 0 --}}
      @foreach ($menus[0] as $level0)
        {{-- LEvel 1  --}}
        @if (!empty($menus[$level0->id]))
        <li class="nav-link header">
          {!! sc_language_render($level0->title) !!}
        </li>
          @foreach ($menus[$level0->id] as $level1)
            @if($level1->uri)
            <li class="nav-item {{ \Admin::checkUrlIsChild(url()->current(), sc_url_render($level1->uri)) ? 'active' : '' }}">
              <a href="{{ $level1->uri?sc_url_render($level1->uri):'#' }}" class="nav-link">
                <i class="nav-icon {{ $level1->icon }}"></i>
                <p>
                  {!! sc_language_render($level1->title) !!}
                </p>
              </a>
            </li>
            @else

          {{-- LEvel 2  --}}
          @if (!empty($menus[$level1->id]))
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon  {{ $level1->icon }} "></i>
                <p>
                  {!! sc_language_render($level1->title) !!}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                @foreach ($menus[$level1->id] as $level2)
                  @if($level2->uri)
                  <li class="nav-item {{ \Admin::checkUrlIsChild(url()->current(), sc_url_render($level2->uri)) ? 'active' : '' }}">
                    <a href="{{ $level2->uri?sc_url_render($level2->uri):'#' }}" class="nav-link">
                      <i class="{{ $level2->icon }} nav-icon"></i>
                      <p>{!! sc_language_render($level2->title) !!}</p>
                    </a>
                  </li>
                  @else

                {{-- LEvel 3  --}}
                @if (!empty($menus[$level2->id]))
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                      <i class="nav-icon  {{ $level2->icon }} "></i>
                      <p>
                        {!! sc_language_render($level2->title) !!}
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>

                  <ul class="nav nav-treeview">
                    @foreach ($menus[$level2->id] as $level3)
                      @if($level3->uri)
                        <li class="nav-item {{ \Admin::checkUrlIsChild(url()->current(), sc_url_render($level3->uri)) ? 'active' : '' }}">
                          <a href="{{ $level3->uri?sc_url_render($level3->uri):'#' }}" class="nav-link">
                            <i class="{{ $level3->icon }} nav-icon"></i>
                            <p>{!! sc_language_render($level3->title) !!}</p>
                          </a>
                        </li>
                      @else
                      <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                          <i class="nav-icon  {{ $level3->icon }} "></i>
                          <p>
                            {!! sc_language_render($level3->title) !!}
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                      </li>
                      @endif
                    @endforeach
                  </ul>                    
                  </li>
                  @endif
                  {{-- end level 3 --}}

                  @endif
                @endforeach
              </ul>
              </li>
            @endif
            {{-- end level 2 --}}

            @endif
          @endforeach
        {{--  end level 1 --}}

          @endif
        @endforeach
      {{-- end level 0 --}}
      @endif


      
      @if (\Admin::user()->checkUrlAllowAccess(route('admin_order.index')))
        @include('admin.component.sidebar_bottom')
      @endif


      </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  