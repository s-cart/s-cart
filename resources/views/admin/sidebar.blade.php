  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Admin::user()->avatar?asset(Admin::user()->avatar):asset('admin/avatar/user.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Admin::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form -->
      <form action="{{ route('admin_order.index') }}" method="get" class="sidebar-form">
        <div class="input-group">
        <input type="text" name="keyword" class="form-control" placeholder="{{trans('order.search')}}">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
@php
  $menus = Admin::getMenuVisible();
@endphp
{{-- Level 0 --}}
        @foreach ($menus[0] as $level0)
        <li class="header">
          {!! sc_language_render($level0->title) !!}
        </li>
        {{-- LEvel 1  --}}
        @if (!empty($menus[$level0->id]))
          @foreach ($menus[$level0->id] as $level1)
            @if($level1->uri)
              <li class=""><a href="{{ $level1->uri?sc_url_render($level1->uri):'#' }}"><i class="fa {{ $level1->icon }}"></i> <span>{!! sc_language_render($level1->title) !!}</span></a></li>
            @else
            <li class="treeview">
              <a href="#">
                <i class="fa {{ $level1->icon }}"></i> <span>{!! sc_language_render($level1->title) !!}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            {{-- LEvel 2  --}}
              <ul class="treeview-menu">
                @if (isset($menus[$level1->id]))
                @foreach ($menus[$level1->id] as $level2)
                  @if($level2->uri)
                    <li class=""><a href="{{ $level2->uri?sc_url_render($level2->uri):'#' }}"><i class="fa {{ $level2->icon }}"></i> <span>{!! sc_language_render($level2->title) !!}</span></a></li>
                  @else
                  <li class="treeview">
                    <a href="#">
                      <i class="fa {{ $level2->icon }}"></i> <span>{!! sc_language_render($level2->title) !!}</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
      
                  {{-- LEvel 3  --}}
                  <ul class="treeview-menu">
                    @if (isset($menus[$level2->id]))
                    @foreach ($menus[$level2->id] as $level3)
                      @if($level3->uri)
                        <li class=""><a href="{{ $level3->uri?sc_url_render($level3->uri):'#' }}"><i class="fa {{ $level3->icon }}"></i> <span>{{ sc_language_render($level3->title) }}</span></a></li>
                      @else
                      <li class="treeview">
                        <a href="#">
                          <i class="fa {{ $level3->icon }}"></i> <span>{!! sc_language_render($level3->title) !!}</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
          
          
                        
                        </li>
                      @endif
                    @endforeach
                    @endif
    
                  </ul>
                  {{-- end level 3 --}}
                    
                    </li>
                  @endif
                @endforeach
                @endif

              </ul>
              {{-- end level 2 --}}
              </li>
            @endif
          @endforeach
      {{--  end level 1 --}}
      @endif
        @endforeach
      {{-- end level 0 --}}

      </ul>

@include('admin.component.sidebar_bottom')

    </section>
    <!-- /.sidebar -->
  </aside>
