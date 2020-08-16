@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
        <div class="card card-primary card-outline card-outline-tabs">
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="#"  aria-controls="custom-tabs-four-home" aria-selected="true">{{ trans('template.local') }}</a>
              </li>
              @if (config('scart.settings.api_template'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('admin_template_online.index') }}" >{{ trans('template.online') }}</a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link" target=_new  href="{{ route('admin_template.import') }}" ><span><i class="fas fa-save"></i> {{ trans('plugin.import_data', ['data' => 'template']) }}</span></a>
              </li>
              <li class="btn-group float-right m-2">
                {!! trans('template.template_more') !!}
              </li>
            </ul>
          </div>

          <div class="card-body" id="pjax-container">
            <div class="tab-content" id="custom-tabs-four-tabContent">
              <table class="table table-hover text-nowrap table-bordered">
                <thead>
                  <tr>
                    <th>{{ trans('template.image') }}</th>
                    <th>{{ trans('template.name') }}</th>
                    <th>{{ trans('template.code') }}</th>
                    <th>{{ trans('template.image_demo') }}</th>
                    <th>{{ trans('template.auth') }}</th>
                    <th>{{ trans('template.website') }}</th>
                    <th>{{ trans('template.version') }}</th>
                    <th>{{ trans('template.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($templates as $key => $template)
                  <tr>
                    @php
                        $pathImage = $template['config']['image'] ?? '';
                    @endphp
                   <td>{!!sc_image_render(asset('templates/'.$key.'/'.$pathImage)??'','50px','', $template['config']['name']??'')!!}</td>
                   <td>{{ $template['config']['name']??'' }}</td>
                   <td>{{ $key??'' }}</td>
                   <td class="pointer" onclick="imagedemo('{{ asset('templates/'.$key.'/images/demo.jpg') }}')"><a>{{ trans('template.click_here') }}</a></td>
                   <td>{{ $template['config']['auth']??'' }}</td>
                   <td><a href="{{ $template['config']['website']??'' }}" target=_new><i class="fa fa-link" aria-hidden="true"></i>Link</a></td>
                   <td>{{ $template['config']['version']??'' }}</td>
                    <td>
                      @if (!in_array($key, $templatesUsed))
                        <span onClick="removeTemplate($(this), '{{ $key }}');" title="{{ trans('template.remove') }}" class="btn btn-flat btn-danger btn-sm"><i class="fa fa-trash"></i></span>
                      @else
                          {{ trans('template.used') }}
                      @endif
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>

            </div>
          </div>
          <!-- /.card -->
        </div>
        </div>
    </div>

@endsection


@push('styles')

@endpush

@push('scripts')


    {{-- //End pjax --}}
    <script type="text/javascript">
      function removeTemplate(obj,key) {

        Swal.fire({
          title: '{{ trans('admin.action_admin.are_you_sure') }}',
          text: '{{ trans('admin.action_admin.delete_warning') }}',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '{{ trans('admin.action_admin.confirm_yes') }}',
        }).then((result) => {
          if (result.value) {
              $('#loading').show()
              obj.button('loading');
              $.ajax({
                type: 'POST',
                dataType:'json',
                url: '{{ route('admin_template.remove') }}',
                data: {
                  "_token": "{{ csrf_token() }}",
                  "key":key,
                },
                success: function (response) {
                  console.log(response);
                if(parseInt(response.error) ==0){
                  alertMsg('success', response.msg);
                location.reload();
                }else{
                  alertMsg('error', response.msg);
                }
                $('#loading').hide();
                obj.button('reset');
                }
              });
          }
        })
    }

function imagedemo(image) {
  Swal.fire({
    title: '{{  trans('template.image_demo') }}',
    text: '',
    imageUrl: image,
    imageWidth: 800,
    imageHeight: 800,
    imageAlt: 'Image demo',
  })
}
    
  </script>
@endpush
