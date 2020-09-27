@if ($listStoreId = \Admin::user()->listStoreId())
@if (count($listStoreId) > 2)
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="fas fa-random"></i> {{ trans('store.admin.switch_store') }}
    </a>
    <div class="dropdown-menu dropdown-menu-left p-0">
    @foreach ($listStoreId as  $stID)
    @if ($stID != 0)
    <a href="{{ route('admin_store.process', ['storeId' => $stID]) }}" class="dropdown-item  {{ (session('adminStoreId') == $stID) ? 'disabled active':'' }}">
        <div class="hover">
            {{ trans('store.admin.config_store', ['id' => $stID]) }}
        </div>
    </a>
    @endif
    @endforeach
    </div>
</li> 
@endif
@endif
