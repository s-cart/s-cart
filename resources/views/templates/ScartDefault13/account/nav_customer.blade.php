<ul class="list-group list-group-flush member-nav">
    <li class="list-group-item">
        <a href="{{ route('member.change_password') }}"><i class="fa fa-unlock-alt"></i> {{ trans('account.change_password') }}</a></li>
    <li class="list-group-item">
        <a href="{{ route('member.change_infomation') }}"><i class="fa fa-info-circle"></i> {{ trans('account.change_infomation') }}
        </a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('member.address_list') }}"><i class="fa fa-bars" aria-hidden="true"></i> {{ trans('account.address_list') }}</a>
    </li>
    <li class="list-group-item">
        <a href="{{ route('member.order_list') }}"><i class="fa fa-clipboard"></i> {{ trans('account.order_list') }}</a>
    </li>
</ul>