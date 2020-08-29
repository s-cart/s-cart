@php
  $newOrders = \App\Models\ShopOrder::where('status',1)->orderBy('id','desc');
  $totalNewOrders = $newOrders->count();
  $orders = $newOrders->limit(10)->get();
@endphp

    <!-- Notifications: style can be found in dropdown.less -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">{{$totalNewOrders}}</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">{{ trans('admin.menu_notice.new_order',['total'=>$totalNewOrders]) }}</span>
        <div class="dropdown-divider"></div>
            @foreach ($orders as $order)
            <a href="{{route('admin_order.detail',['id'=>$order->id])}}" class="dropdown-item">
              #{{$order->id}} - {{ trans('admin.menu_notice.date') }}: {{$order->created_at}}
            </a>
            <div class="dropdown-divider"></div>                     
            @endforeach
          <a href="{{route('admin_order.index')}}?order_status=1" class="dropdown-item dropdown-footer">{{ trans('admin.menu_notice.view_all') }}</a>
      </div>
    </li>
