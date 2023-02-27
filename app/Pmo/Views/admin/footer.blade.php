<footer class="main-footer">
  @if (!sc_config('hidden_copyright_footer_admin'))
    <div class="float-right d-none d-sm-inline-block">
      <strong>Env</strong>
      {{ config('app.env') }}
      &nbsp;&nbsp;
      <strong>Version</strong> 
      {{ config('s-pmo.sub-version') }} ({{ config('s-pmo.core-sub-version') }})
    </div>
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('s-pmo.homepage') }}">s-pmo: {{ config('s-pmo.title') }}</a>.</strong> All rights
    reserved.
  @endif
</footer>
