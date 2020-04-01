@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
          <div class="box-body">
            <div class="error-page text-center">
                <h3 class="text-red">403</h3>
                <h5 class="text-red">{{ trans('admin.deny_content') }}</h5>
                @if ($url)
                <span><i class="fa fa-warning text-red" aria-hidden="true"></i> You cannot access to url <code>{{ $url }}</code> method <code>{{ $method }}</code></span>
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
