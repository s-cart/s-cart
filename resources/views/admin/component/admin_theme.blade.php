<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
        {{ trans('admin.theme') }}
    </a>
    <div class="dropdown-menu dropdown-menu-left p-0">
    @foreach (config('admin.theme') as  $theme)
    <a href="{{ route('admin.theme', ['theme' => $theme]) }}" class="dropdown-item  {{ (config('admin.theme_default') == $theme) ? 'disabled active':'' }}">
        <div class="hover">
        {{ ucfirst($theme) }}
        </div>
    </a>
    @endforeach
    </div>
</li>