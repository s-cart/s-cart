   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-light-pink elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="{{ sc_route_admin('admin.home') }}" class="brand-link navbar-secondary"">
      {!! sc_config_admin('ADMIN_LOGO') !!}
    </a>

    <!-- Sidebar -->
    <div class="sidebar {{ config($styleDefine.'.sidebar') }}">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" >

          @if (\Admin::user()->checkUrlAllowAccess(sc_route_admin('admin_order.index')))
          <!-- SEARCH FORM -->
          <form action="{{ sc_route_admin('admin_order.index') }}" method="get" class="form-inline m-1 d-block d-sm-none" >
            <div class="input-group input-group-sm">
              <input name="keyword" class="form-control form-control-navbar" type="search" placeholder="{{ sc_language_render('admin.order.search') }}" aria-label="Search">
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
          <i class="nav-icon  {{ $level0->icon }} "></i> 
          <p class="sub-header"> {!! sc_language_render($level0->title) !!}</p>
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
        @include($templatePathAdmin.'component.sidebar_bottom')
      @endif


      </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  