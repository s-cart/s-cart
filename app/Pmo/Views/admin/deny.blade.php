@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
          <div class="box-body">
            <div class="error-page text-center">
                <h2 class="text-red">403 - {{ sc_language_render('admin.deny_content') }}</h2>
                @if ($url)
                <span><h4><i class="fa fa-warning text-red" aria-hidden="true"></i> {{ sc_language_render('admin.deny_msg') }}</h4></span>
                <span><strong>URL:</strong> <code>{{ $url }}</code> - <strong>Method:</strong> <code>{{ $method }}</code></span>
                @endif
            </div>
        </div>
      </div>
  </div>
@endsection


@push('styles')
@endpush

@push('scripts')
@if ($url)
<script>
  window.history.pushState("", "", '{{ $url }}');
</script>
@endif
@endpush
