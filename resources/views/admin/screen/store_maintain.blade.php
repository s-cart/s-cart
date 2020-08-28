@extends('admin.layout')

@section('main')

<div class="row">
  <div class="col-md-12">

    @foreach ($stories as $store)
    <div class="card collapsed-card">
      <div class="card-header with-border">
        <h3 class="card-title"><i class="fas fa-home"></i> {{ trans('store_maintain.admin.content') }} #{{ $store->id }}</h3>
        <div class="card-tools">
          <div class="block-action"><a href="{{ route('admin_store_maintain.edit', ['id' => $store->id]) }}"><i class="fa fa-edit" aria-hidden="true"></i>{{ trans('admin.edit') }}</a></div>
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      @php
      $descriptions = $store->descriptions->keyBy('lang');
      @endphp

      <div class="card-body">
        @foreach ($descriptions as  $codeLang => $infoDescription)
        @php
            if (!in_array($codeLang, array_keys($languages->toArray()))) {
              continue;
            }
        @endphp
        <div class="row">
          <div class="col-md-12">
          <div class="card-header with-border">
            <h3 class="card-title">{{ $languages[$codeLang]['name'] }} <img src="{{ asset($languages[$codeLang]->icon )}}" style="width:20px">:</h3>
          </div>
          <div class="table-responsivep-0">
            {!! sc_html_render($infoDescription['maintain_content']) !!}
          </div>
          </div>
        </div>
        @endforeach
      </div>

    </div>
    @endforeach
  </div>

</div>


@endsection


@push('styles')

@endpush

@push('scripts')

    {{-- //Pjax --}}
   <script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

    $(document).on('pjax:send', function() {
      $('#loading').show()
    })
    $(document).on('pjax:complete', function() {
      $('#loading').hide()
    })
    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

    $(document).on('ready pjax:end', function(event) {
//
    })

  </script>

@endpush
