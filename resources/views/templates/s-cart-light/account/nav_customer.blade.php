<ul class="list-group list-group-flush member-nav">
    <li class="list-group-item">
        <a href="{{ sc_route('customer.change_password') }}"><i class="fas fa-unlock-alt"></i> {{ trans('account.change_password') }}</a></li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.change_infomation') }}"><i class="fas fa-info-circle"></i> {{ trans('account.change_infomation') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.address_list') }}"><i class="fa fa-bars" aria-hidden="true"></i> {{ trans('account.address_list') }}</a>
    </li>
    <li class="list-group-item">
        <a href="{{ sc_route('customer.order_list') }}"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> {{ trans('account.order_list') }}</a>
    </li>
</ul>