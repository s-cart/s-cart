@if (sc_store('active') == '1'  || (sc_store('active') == '0' && auth()->guard('admin')->user()))
    {{-- Admin logged can view the website content under maintenance --}}
    @if (sc_store('active') == '0' && auth()->guard('admin')->user())
        @includeIf($sc_templatePath . '.maintenance_note')
    @endif
    @include($sc_templatePath . '.main')
@else
    @include($sc_templatePath . '.maintenance')
@endif