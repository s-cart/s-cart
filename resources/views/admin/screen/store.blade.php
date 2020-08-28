@extends('admin.layout')

@section('main')

<div class="row">
  <div class="col-md-12">
    <div class="card">

      <div class="card-header with-border">
        <div class="float-left">
          <input class="form-control form-control-lg domain-strict" name="domain_strict" data-on-text="{{ trans('config.domain_strict_on') }}" data-off-text="{{ trans('config.domain_strict_off') }}" type="checkbox"  {{ (sc_config_global('domain_strict') == '1'?'checked':'') }}>
          <div class="form-text"><i class="fas fa-exclamation-triangle"></i> {{ trans('config.domain_strict_help') }}</div>
        </div>
        <div class="card-tools">
          <div class="menu-right">
              <a href="{{ route('admin_store.create') }}" class="btn btn-success btn-flat btn-md" title="New" id="button_create_new">
              <i class="fa fa-plus" title="{{ trans('store.admin.add_new') }}"></i>
              </a>
          </div>
        </div>
      </div>

      <div class="card-body">
        @foreach ($stories as $store)
        <div class="card {{ ($stories->count() > 1)? 'collapsed-card':'' }}">
          <div class="card-header with-border">
            <h3 class="card-title"><i class="fas fa-home"></i> {{ trans('store.admin.title') }} #{{ $store->id }} 
              (<i class="fas fa-link"></i> <a target=_new href="//{{ $store->domain }}">{{ $store->domain }}</a>)
            </h3>
            <div class="card-tools">
              <div class="menu-right">
                @if ($store->id != 1)
                <input class="store-status" data-store="{{ $store->id }}" name="status" data-on-text="{{ trans('admin.unlock') }}" data-off-text="{{ trans('admin.lock') }}" type="checkbox"  {{ ($store->status == '1'?'checked':'') }}>
                @endif
                <input class="store-active" data-store="{{ $store->id }}" name="active" data-on-text="{{ trans('admin.maintain_enable') }}" data-off-text="{{ trans('admin.maintain_disable') }}" type="checkbox"  {{ ($store->active == '1'?'checked':'') }}>
                @if ($store->id != 1)
                <span onclick="deleteItem({{ $store->id }});" title="Delete" class="btn btn-flat btn-sm btn-danger">
                  <i class="fas fa-trash-alt"></i>
                </span>
                @endif
                <a href="{{ route('admin_store.config', ['id' => $store->id]) }}"><span title="Config" class="btn btn-flat btn-sm btn-primary">
                  <i class="fas fa-cogs"></i>
                </span>
                </a>
              </div>
            </div>
          </div>
      </div>
      @endforeach
      </div>

    </div>
    </div>
</div>

@endsection


@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
<style type="text/css">
  #maintain_content img{
    max-width: 100%;
  }
</style>
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

  <script type="text/javascript">

    {!! $script_sort??'' !!}

  </script>

{{-- //Pjax --}}
<script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

<script>
  // Update store_info

  function deleteItem(id){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ trans('admin.store_confirm_delete') }} #'+id,
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ trans('admin.confirm_delete_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ trans('admin.confirm_delete_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ $urlDeleteItem ?? '' }}',
                data: {
                  id:id,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                  console.log(data);
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ trans('admin.warning') }}');
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      alertMsg('success', data.msg);
                      $.pjax.reload('#pjax-container');
                      resolve(data);
                    }

                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      alertMsg('success', '{{ trans('admin.confirm_delete_deleted_msg') }}', '{{ trans('admin.confirm_delete_deleted') }}');
    } else if (
      // Read more about handling dismissals
      result.dismiss === Swal.DismissReason.cancel
    ) {
    }
  })
}
  //End update store_info
</script>

<script type="text/javascript">
  $(".store-status, .store-active").bootstrapSwitch();
  $('.store-status, .store-active').on('switchChange.bootstrapSwitch', function (event, state) {
      var site_status;
      if (state == true) {
          site_status =  '1';
      } else {
          site_status = '0';
      }
      $('#loading').show();

      $.ajax({
        type: 'POST',
        dataType:'json',
        url: "{{ route('admin_store.update') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          "storeId": $(this).data('store'),
          "name": $(this).attr('name'),
          "value": site_status
        },
        success: function (response) {
            // console.log(site_status);
          if(parseInt(response.error) ==0){
            alertMsg('success', '{{ trans('admin.msg_change_success') }}');
          }else{
            alertMsg('error', response.msg);
          }
          $('#loading').hide();
        }
      });
  }); 

  $(".domain-strict").bootstrapSwitch().on('switchChange.bootstrapSwitch', function (event, state) {
      var site_status;
      if (state == true) {
          site_status =  '1';
      } else {
          site_status = '0';
      }
      $('#loading').show();

      $.ajax({
        type: 'POST',
        dataType:'json',
        url: "{{ route('admin_config.update') }}",
        data: {
          "_token": "{{ csrf_token() }}",
          "name": $(this).attr('name'),
          "value": site_status
        },
        success: function (response) {
            // console.log(site_status);
          if(parseInt(response.error) ==0){
            alertMsg('success', '{{ trans('admin.msg_change_success') }}');
          }else{
            alertMsg('error', response.msg);
          }
          $('#loading').hide();
        }
      });
  }); 

</script>

@endpush
