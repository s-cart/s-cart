@extends('admin.layout')

@if (!empty($dataNotFound))
  @section('main')
      <div class="card">
        <div class="card-tools">
            <div class="btn-group float-right">
                <a href="{{ route('admin_store.index') }}" class="btn  btn-flat btn-default" title="List">
                    <i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span>
                </a>
            </div>
        </div>
        <div class="card-header with-border">
          <h2 class="card-title">{{ $title_description??'' }}</h2>
          <div class="card-tools">
              <div class="btn-group float-right mr-5">
                  <a href="{{ route('admin_store.index') }}" class="btn  btn-flat btn-default" title="List">
                      <i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span>
                  </a>
              </div>
          </div>
      </div>
        <div class="card-body table-responsivep-0">
          {{ trans('admin.data_notfound') }}
        </div>
      </div>
  @endsection
@else
@section('main')
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-tools">
            <div class="btn-group float-right">
                <a href="{{ route('admin_store.index') }}" class="btn  btn-flat btn-default" title="List">
                    <i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span>
                </a>
            </div>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            {{-- Tab infomation --}}
              <div class="row">
                <div class="col-md-5">
                  <table class="table table-hover table-bordered">
                  <tbody>
                    <tr>
                      <td>{{ trans('store.logo') }}</td>
                      <td>
                          <div class="input-group">
                              <input type="hidden" id="logo" name="logo" value="{{ $store->logo }}" class="form-control input-sm logo" placeholder=""  />
                          </div>
                          <div id="preview_image" class="img_holder">{!! sc_image_render($store->logo,'100px', '', 'Logo') !!}</div>
                            <a data-input="logo" data-preview="preview_image" data-type="logo" class="lfm pointer">
                              <i class="fa fa-image"></i> {{trans('product.admin.choose_image')}}
                            </a>
                      </td>
                    </tr>
              
                    <tr>
                      <td><i class="fas fa-phone-alt"></i> {{ trans('store.phone') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="phone" data-type="number" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.phone') }}" data-value="{{ $store->phone }}" data-original-title="" title="">{{$store->phone }}</a></td>
                    </tr>
              
                    <tr>
                      <td><i class="fas fa-phone-square"></i> {{ trans('store.long_phone') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="long_phone" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.long_phone') }}" data-value="{{ $store->long_phone }}" data-original-title="" title="">{{$store->long_phone }}</a></td>
                    </tr>
              
                    <tr>
                      <td><i class="far fa-calendar-alt"></i> {{ trans('store.time_active') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="time_active" data-type="textarea" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.time_active') }}" data-value="{{ $store->time_active }}" data-original-title="" title="">{{$store->time_active }}</a></td>
                    </tr>
              
                    <tr>
                      <td><i class="fas fa-map-marked"></i> {{ trans('store.address') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="address" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.address') }}" data-value="{{ $store->address }}" data-original-title="" title="">{{$store->address }}</a></td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-location-arrow"></i></span> {{ trans('store.office') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="office" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.office') }}" data-value="{{ $store->office }}" data-original-title="" title="">{{$store->office }}</a></td>
                    </tr>
                    <tr>
                      <td><i class="fas fa-warehouse"></i> {{ trans('store.warehouse') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="warehouse" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.warehouse') }}" data-value="{{ $store->warehouse }}" data-original-title="" title="">{{$store->warehouse }}</a></td>
                    </tr>
              
                    <tr>
                      <td><i class="fas fa-envelope"></i> {{ trans('store.email') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="email" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.email') }}" data-value="{{ $store->email }}" data-original-title="" title="">{{$store->email }}</a></td>
                    </tr>
              
                    <tr>
                      <td><i class="fab fa-chrome"></i> {{ trans('store.domain') }}</td>
                      <td><a href="#" class="editable-required editable editable-click" data-name="domain" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.domain') }}" data-value="{{ $store->domain }}" data-original-title="" title="">{{$store->domain }}</a></td>
                    </tr>
          
                    <tr>
                      <td><i class="far fa-money-bill-alt nav-icon"></i> {{ trans('store.currency') }}</td>
                      <td>
                        <a href="#" class="editable-required editable editable-click" data-name="currency" data-type="select" data-pk="" data-source="{{ json_encode($currencies) }}" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.currency') }}" data-value="{{ $store->currency }}" data-original-title="" title=""></a>
                       </td>
                    </tr>
          
          
                    <tr>
                      <td><i class="fas fa-language nav-icon"></i> {{ trans('store.language') }}</td>
                      <td>
                        <a href="#" class="editable-required editable editable-click" data-name="language" data-type="select" data-pk="" data-source="{{ json_encode($languages->pluck('name','code')->toArray()) }}" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.language') }}" data-value="{{ $store->language }}" data-original-title="" title=""></a>
                       </td>
                    </tr>
          
                    <tr>
                      <td><i class="fas fa-clock"></i> {{ trans('store.timezone') }}</td>
                      <td>
                        <a href="#" class="editable-required editable editable-click" data-name="timezone" data-type="select" data-pk="" data-source="{{ json_encode($timezones) }}" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.timezone') }}" data-value="{{ $store->timezone }}" data-original-title="" title=""></a>
                       </td>
                    </tr>
          
                    <tr>
                      <td><i class="nav-icon  fas fa-object-ungroup "></i>{{ trans('store.template') }}</td>
                      <td>
                        <a href="#" class="editable-required editable editable-click" data-name="template" data-type="select" data-pk="" data-source="{{ json_encode($templates) }}" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.template') }}" data-value="{{ $store->template }}" data-original-title="" title=""></a>
                       </td>
                    </tr>
          
                  </td>
                </tr>
              
                  </tbody>
                     </table>
                </div>
              @php
                  $descriptions = $store->descriptions->keyBy('lang');
              @endphp
                <div class="col-md-7">
                  <table class="table table-hover table-bordered">
                    <tbody>
                      <tr>
                        <td>{{ trans('store.title') }}</td>
                        <td>
                          @foreach ($descriptions as  $codeLang => $infoDescription)
                          @php
                              if (!in_array($codeLang, array_keys($languages->toArray()))) {
                                continue;
                              }
                          @endphp
                            {{ $languages[$codeLang]->name }} <img src="{{ asset($languages[$codeLang]->icon )}}" style="width:20px">:<br>
                          <i><a href="#" class="editable-required editable editable-click" data-name="{{ 'title__'.$codeLang }}" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.title') }}" data-value="{{ $infoDescription['title'] }}" data-original-title="" title="">{{ $infoDescription['title'] }}</a></i><br>
                          <br>
                          @endforeach
                        </td>
                      </tr>
          
                      <tr>
                        <td>{{ trans('store.keyword') }}</td>
                        <td>
                          @foreach ($descriptions as  $codeLang => $infoDescription)
                          @php
                              if (!in_array($codeLang, array_keys($languages->toArray()))) {
                                continue;
                              }
                          @endphp
                            {{ $languages[$codeLang]->name }} <img src="{{ asset($languages[$codeLang]->icon )}}" style="width:20px">:<br>
                          <i><a href="#" class="editable-required editable editable-click" data-name="{{ 'keyword__'.$codeLang }}" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.keyword') }}" data-value="{{ $infoDescription['keyword'] }}" data-original-title="" title="">{{ $infoDescription['keyword'] }}</a></i><br>
                          <br>
                          @endforeach
                        </td>
                      </tr>
          
                      <tr>
                        <td>{{ trans('store.description') }}</td>
                        <td>
                          @foreach ($descriptions as  $codeLang => $infoDescription)
                          @php
                              if (!in_array($codeLang, array_keys($languages->toArray()))) {
                                continue;
                              }
                          @endphp
                            {{ $languages[$codeLang]->name }} <img src="{{ asset($languages[$codeLang]->icon )}}" style="width:20px">:<br>
                          <i><a href="#" class="editable-required editable editable-click" data-name="{{ 'description__'.$codeLang }}" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_store.update') }}" data-title="{{ trans('store.description') }}" data-value="{{ $infoDescription['description'] }}" data-original-title="" title="">{{ $infoDescription['description'] }}</a></i><br>
                          <br>
                          @endforeach
                        </td>
                      </tr>
          
                  </tbody>
                  </table>
                </div>
              
              </div>
            {{-- //End tab infomation --}}
          </div>
        </div>
        <!-- /.card -->
</div>

@endsection
@endif

@push('styles')
<!-- Ediable -->
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
<style type="text/css">
  #maintain_content img{
    max-width: 100%;
  }
</style>
@endpush

@if (empty($dataNotFound))
@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">

  // Editable
$(document).ready(function() {

      //  $.fn.editable.defaults.mode = 'inline';
      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        params.storeId = "{{ $storeId }}";
        return params;
      };

      $('.editable-required').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  trans('admin.not_empty') }}';
            }
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ trans('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });

    $('.editable').editable({
        validate: function(value) {
        },
        success: function(data) {
          if(data.error == 0){
            alertJs('success', '{{ trans('admin.msg_change_success') }}');
          } else {
            alertMsg('error', data.msg);
          }
      }
    });

});
</script>


  <script type="text/javascript">

    {!! $script_sort??'' !!}

  </script>

{{-- //Pjax --}}
<script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

<script>
  // Update store_info

//Logo
  $('.logo').change(function() {
        $.ajax({
        url: '{{ route('admin_store.update') }}',
        type: 'POST',
        dataType: 'JSON',
        data: {"name": $(this).attr('name'),"value":$(this).val(),"_token": "{{ csrf_token() }}", "storeId": "{{ $storeId }}" },
      })
      .done(function(data) {
        if(data.error == 0){
          alertJs('success', '{{ trans('admin.msg_change_success') }}');
        } else {
          alertJs('error', data.msg);
        }
      });
  });
//End logo


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

@endpush
@endif