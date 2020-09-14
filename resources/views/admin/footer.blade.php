<footer class="main-footer">
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 
    @if (env('SC_VERSION'))
    {{ env('SC_VERSION') }}
    @else
    {{ config('scart.sub_version') }}
    @endif
  </div>
  <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('scart.homepage') }}">SCart: {{ config('scart.title') }}</a>.</strong> All rights
  reserved.
</footer>
