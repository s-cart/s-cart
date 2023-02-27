<div id="maintenance_note">{!! sc_store('maintain_note') !!}</div>
@push('styles')
  <style>
    #maintenance_note {
      display: block;
      color:red;
      z-index: 9999;
      font-size: 25px;
    }
  </style>
@endpush