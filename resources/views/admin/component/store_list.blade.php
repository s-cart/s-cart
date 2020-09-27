@php
   $stores = \App\Models\AdminStore::getDomainActive();
@endphp
<li class="nav-item dropdown">
    @if (count($stores) == 1)
    <a class="nav-link" href="{{ route('home') }}" target=_new>
        <i class="fas fa-home"></i>
    </a> 
    @else
    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="fas fa-home"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-left p-0" style="left: inherit; left: 0px;">
        @foreach ($stores as $id => $domain)
        <a href="//{{ sc_store('domain', $id) }}" target=_new  class="dropdown-item" title="{{ sc_store('title', $id) }}">
        <div class="hover">
            <i class="fab fa-shopify"></i> {{ $domain }}
        </div>
        </a>
        @endforeach
    </div>
    @endif

</li>