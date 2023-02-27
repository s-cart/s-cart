@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
          <div class="box-body">
            <div class="error-page text-center">
              <h1>{{ sc_language_render('admin.welcome_dasdboard') }}</h1>
            </div>
        </div>
      </div>
  </div>
@endsection


@push('styles')
@endpush

@push('scripts')
@endpush
