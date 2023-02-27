
@php
    $orderNew = \App\Pmo\Admin\Models\AdminOrder::getCountOrderNew()
@endphp
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell"></i>
      <span class="badge badge-warning navbar-badge">{{ $orderNew }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-item dropdown-header">{{ sc_language_render('admin.notice_new_order',['total'=> $orderNew]) }}</span>
      <div class="dropdown-divider"></div>
        <a href="{{ sc_route_admin('admin_order.index') }}?order_status=1" class="dropdown-item dropdown-footer">{{ sc_language_render('action.view_more') }}</a>
    </div>
  </li>
