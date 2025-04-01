@php
   //EN: This is where the views are rendered directly from plugins through the helper gp247_push_include_view and gp247_push_include_script
@endphp

@if (!empty($layout_page) && $includePathView = config('gp247_include_view.'.$layout_page, []))
   @foreach ($includePathView as $view)
      @includeIf($view)
   @endforeach
@endif

@push('scripts')
   @if (!empty($layout_page) && $includePathScript = config('gp247_include_script.'.$layout_page, []))
      @foreach ($includePathScript as $script)
         @includeIf($script)
      @endforeach
   @endif
@endpush