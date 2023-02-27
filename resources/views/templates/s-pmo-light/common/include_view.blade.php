@if (!empty($layout_page) && $includePathView = config('sc_include_view.'.$layout_page, []))
   @foreach ($includePathView as $view)
      @includeIf($view)
   @endforeach
@endif

@push('scripts')
   @if (!empty($layout_page) && $includePathScript = config('sc_include_script.'.$layout_page, []))
      @foreach ($includePathScript as $script)
         @includeIf($script)
      @endforeach
   @endif
@endpush