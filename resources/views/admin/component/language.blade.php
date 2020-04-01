@php
    $languages     = sc_language_all();
@endphp
<div style="margin:10px;" class="btn-group">
    <button type="button" class="dropdown-toggle usa" data-toggle="dropdown" aria-expanded="false"><img src="{{ asset($languages[session('locale')??app()->getLocale()]['icon']) }}" style="height: 25px;"><span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        @foreach ($languages as $key=> $language)
        <li>
            <a href="{{ route('admin.locale', ['code' => $key]) }}"><img src="{{ asset($language['icon']) }}" style="height: 25px;"></a>
        </li>
        @endforeach
    </ul>
</div>
