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