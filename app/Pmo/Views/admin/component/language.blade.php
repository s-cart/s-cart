@php
    $languages     = sc_language_all();
@endphp

    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
            <img src="{{ sc_file($languages[session('locale')??app()->getLocale()]['icon']) }}" style="height: 25px;"> 
        </a>
        <div class="dropdown-menu dropdown-menu-left p-0" style="left: inherit; left: 0px;">
            @foreach ($languages as $key=> $language)
            <a href="{{ sc_route_admin('admin.locale', ['code' => $key]) }}" class="dropdown-item {{ ((session('locale')??app()->getLocale()) == $key)?' disabled':'' }}">
            <div class="hover">
                <img src="{{ sc_file($language['icon']) }}" style="height: 25px;"> {{ $language['name'] }}
            </div>
            </a>
            @endforeach
        </div>
      </li>