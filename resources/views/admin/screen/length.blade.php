@extends('admin.layout')

@section('main')
@php
    $id = empty($id) ? 0 : $id;
@endphp
<div class="row">

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{!! $title_action !!}</h3>
        @if ($layout == 'edit')
        <div class="btn-group float-right" style="margin-right: 5px">
            <a href="{{ route('admin_length_unit.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
        </div>
      @endif
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main">
        <div class="card-body">

          <div class="form-group row {{ $errors->has('name') ? ' text-red' : '' }}">
            <label for="name" class="col-sm-2 col-form-label">{{ trans('length.name') }}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="name" name="name" value="{!! old()?old('name'):$length['name']??'' !!}" class="form-control name {{ $errors->has('name') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('name'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('name') }}
              </span>
              @endif

            </div>
          </div>

          <div class="form-group row {{ $errors->has('description') ? ' text-red' : '' }}">
            <label for="description" class="col-sm-2 col-form-label">{{ trans('length.description') }}</label>
            <div class="col-sm-10 ">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                </div>
                <input type="text" id="description" name="description" value="{!! old()?old('description'):$length['description']??'' !!}" class="form-control description {{ $errors->has('description') ? ' is-invalid' : '' }}">
              </div>

              @if ($errors->has('description'))
              <span class="text-sm">
                <i class="fa fa-info-circle"></i> {{ $errors->first('description') }}
              </span>
              @endif

            </div>
          </div>



        </div>
        <!-- /.card-body -->
        @csrf
        <div class="card-footer">
          <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
          <button type="submit" class="btn btn-primary float-right">{{ trans('admin.submit') }}</button>
        </div>
        <!-- /.card-footer -->
      </form>
    </div>
  </div>


  <div class="col-md-6">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-th-list"></i> {!! $title ?? '' !!}</h3>
      </div>

      <div class="card-body p-0">
            <section id="pjax-container" class="table-list">
              <div class="box-body table-responsivep-0" >
                 <table class="table table-hover">
                    <thead>
                       <tr>
                        @if (!empty($removeList))
                        <th></th>
                        @endif
                        @foreach ($listTh as $key => $th)
                            <th>{!! $th !!}</th>
                        @endforeach
                       </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataTr as $keyRow => $tr)
                            <tr class="{{ ($id == $tr['id']) ? 'active': '' }}">
                                @if (!empty($removeList))
                                <td>
                                  <input class="input" type="checkbox" class="grid-row-checkbox" data-id="{{ $tr['id']??'' }}">
                                </td>
                                @endif
                                @foreach ($tr as $key => $trtd)
                                    <td>{!! $trtd !!}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                 </table>
                 <div class="block-pagination clearfix m-10">
                  <div class="ml-3 float-left">
                    {!! $resultItems??'' !!}
                  </div>
                  <div class="pagination pagination-sm mr-3 float-right">
                    {!! $pagination??'' !!}
                  </div>
                </div>
              </div>
             </section>
    </div>



    </div>
  </div>

</div>
</div>
@endsection


@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

    $('.grid-refresh').click(function(){
      $.pjax.reload({container:'#pjax-container'});
    });

      $(document).on('submit', '#button_search', function(event) {
        $.pjax.submit(event, '#pjax-container')
      })

    $(document).on('pjax:send', function() {
      $('#loading').show()
    })
    $(document).on('pjax:complete', function() {
      $('#loading').hide()
    })

    // tag a
    $(function(){
     $(document).pjax('a.page-link', '#pjax-container')
    })


    $(document).ready(function(){
    // does current browser support PJAX
      if ($.support.pjax) {
        $.pjax.defaults.timeout = 2000; // time in milliseconds
      }
    });

    @if ($buttonSort)
      $('#button_sort').click(function(event) {
        var url = '{{ $urlSort??'' }}?sort_shipping='+$('#shipping_sort option:selected').val();
        $.pjax({url: url, container: '#pjax-container'})
      });
    @endif
    

    $(document).on('ready pjax:end', function(event) {
      $('.input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    })

  </script>
    {{-- //End pjax --}}


<script type="text/javascript">
{{-- sweetalert2 --}}
var selectedRows = function () {
    var selected = [];
    $('.grid-row-checkbox:checked').each(function(){
        selected.push($(this).data('id'));
    });

    return selected;
}

$('.grid-trash').on('click', function() {
  var ids = selectedRows().join();
  deleteItem(ids);
});

  function deleteItem(ids){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ trans('admin.confirm_delete') }}',
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
                  ids:ids,
                    _token: '{{ csrf_token() }}',
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ trans('admin.warning') }}');
                      $.pjax.reload('#pjax-container');
                      return;
                    }else{
                      alertMsg('success', data.msg);
                      window.location.replace('{{ route('admin_length_unit.index') }}');
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
      // swalWithBootstrapButtons.fire(
      //   'Cancelled',
      //   'Your imaginary file is safe :)',
      //   'error'
      // )
    }
  })
}
{{--/ sweetalert2 --}}


</script>

{!! $js ?? '' !!}
@endpush
