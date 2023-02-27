@extends($templatePathAdmin.'layout')
@section('main')
      <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header with-border">
            <h3 class="card-title">{{ $title }}</h3>
          </div>
          <div class="card-body">
             <table class="table">
               <tbody>
                <tr>
                  <td>
                    {!! sc_language_render('admin.seo.url_seo_lang') !!}
                  </td>
                  <td>
                    <input class="check-data-config-global"  type="checkbox" name="url_seo_lang" {{ sc_config_global('url_seo_lang')?"checked":"" }}>
                  </td>
                </tr>
               </tbody>
             </table>
          </div>
      </div>
      </div>
    </div>
@endsection


@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ sc_file('admin/plugin/bootstrap-editable.css')}}">
<style type="text/css">
  #maintain_content img{
    max-width: 100%;
  }
</style>
@endpush

@if (empty($dataNotFound))
@push('scripts')
<!-- Ediable -->
<script src="{{ sc_file('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">

$('input.check-data-config-global').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' /* optional */
  }).on('ifChanged', function(e) {
  var isChecked = e.currentTarget.checked;
  isChecked = (isChecked == false)?0:1;
  var name = $(this).attr('name');
    $.ajax({
      url: '{{ $urlUpdateConfigGlobal }}',
      type: 'POST',
      dataType: 'JSON',
      data: {
          "_token": "{{ csrf_token() }}",
          "name": $(this).attr('name'),
          "value": isChecked
        },
    })
    .done(function(data) {
      if(data.error == 0){
        if (isChecked == 0) {
          $('#smtp-config').hide();
        } else {
          $('#smtp-config').show();
        }
        alertJs('success', '{{ sc_language_render('admin.msg_change_success') }}');
      } else {
        alertJs('error', data.msg);
      }
    });

    });


</script>

{{-- //Pjax --}}
<script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>


<script>
  // Update store_info

//End update store_info
</script>

@endpush
@endif