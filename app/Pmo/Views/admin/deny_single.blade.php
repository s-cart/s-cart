<div>
  <h2 style="color:red; font-size:15px;">403 - {{ sc_language_render('admin.deny_content') }}</h2>
  @if ($url)
  <span><h4 style="color:red; font-size:12px;"> {{ sc_language_render('admin.deny_msg') }}</h4></span>
  <span><strong>URL:</strong> <code>{{ $url }}</code> - <strong>Method:</strong> <code>{{ $method }}</code></span>
  @endif
</div>