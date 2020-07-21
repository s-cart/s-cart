@extends('admin.layout')

@section('main')
@php
    $id = empty($id) ? 0 : $id;
@endphp
<div class="row">

  <div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{!! $title_action !!}</h3>
      </div>

      <div class="box-body table-responsive box-primary">
        <div class="box-header with-border">
          <div class="box-body no-padding" >
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main">
                  <div class="fields-group">
                    
                    <div class="form-group   {{ $errors->has('name') ? ' has-error' : '' }}">
                      <label for="name"
                          class="col-sm-2 col-form-label">{{ trans('language.name') }}</label>
                      <div class="col-sm-8">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                              <input type="text" id="name" name="name"
                                  value="{!! old()?old('name'):$language['name']??'' !!}"
                                  class="form-control" placeholder="" />
                          </div>
                          @if ($errors->has('name'))
                          <span class="help-block">
                              {{ $errors->first('name') }}
                          </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group   {{ $errors->has('code') ? ' has-error' : '' }}">
                      <label for="code"
                          class="col-sm-2 col-form-label">{{ trans('language.code') }}</label>
                      <div class="col-sm-8">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                              @if (!empty($language['code']) && in_array($language['code'], ['vi','en']))
                              <input type="hidden" id="code" name="code" value="{!! $language['code'] !!}"
                                  placeholder="" />
                              <input type="text" disabled="disabled" value="{!! $language['code'] !!}"
                                  class="form-control" placeholder="" />
                              @else
                              <input type="text" id="code" name="code"
                                  value="{!! old()?old('code'):$language['code']??'' !!}"
                                  class="form-control" placeholder="" />
                              @endif
                          </div>
                          @if ($errors->has('code'))
                          <span class="help-block">
                              {{ $errors->first('code') }}
                          </span>
                          @endif
                      </div>
                  </div>



                  <div class="form-group   {{ $errors->has('icon') ? ' has-error' : '' }}">
                      <label for="icon"
                          class="col-sm-2 col-form-label">{{ trans('language.icon') }}</label>
                      <div class="col-sm-8">
                          <div class="input-group">
                              <input type="text" id="icon" name="icon"
                                  value="{!! old('icon',$language['icon']??'') !!}"
                                  class="form-control input-sm icon" placeholder="" />
                              <span class="input-group-btn">
                                  <a data-input="icon" data-preview="preview_icon" data-type="language"
                                      class="btn btn-sm btn-primary lfm">
                                      <i class="fa fa-image"></i>
                                      {{trans('admin.choose_icon')}}
                                  </a>
                              </span>
                          </div>
                          @if ($errors->has('icon'))
                          <span class="help-block">
                              {{ $errors->first('icon') }}
                          </span>
                          @endif
                          <div id="preview_icon" class="img_holder"><img
                                  src="{{ asset(old('icon',$language['icon']??'')) }}"></div>
                      </div>
                  </div>

                  <div class="form-group   {{ $errors->has('rtl') ? ' has-error' : '' }}">
                      <label for="rtl"
                          class="col-sm-2 col-form-label">{{ trans('language.layout_rtl') }}</label>
                          <div class="col-sm-8">
                              <input type="checkbox" name="rtl" {!!
                                  old('rtl',(empty($language['rtl'])?0:1))?'checked':''!!}>

                          </div>
                  </div>

                  <div class="form-group   {{ $errors->has('sort') ? ' has-error' : '' }}">
                      <label for="sort"
                          class="col-sm-2 col-form-label">{{ trans('language.sort') }}</label>
                      <div class="col-sm-8">
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                              <input type="number" style="width: 100px;" min=0 id="sort" name="sort"
                                  value="{!! old()?old('sort'):$language['sort']??0 !!}"
                                  class="form-control sort" placeholder="" />
                          </div>
                          @if ($errors->has('sort'))
                          <span class="help-block">
                              {{ $errors->first('sort') }}
                          </span>
                          @endif
                      </div>
                  </div>


                  <div class="form-group  ">
                      <label for="status"
                          class="col-sm-2 col-form-label">{{ trans('language.status') }}</label>
                      <div class="col-sm-8">
                          <input class="input" type="checkbox" name="status" {!!
                              old('status',(empty($language['status'])?0:1))?'checked':''!!}>

                      </div>
                  </div>

                  </div>
              </div>
              <!-- /.box-body -->
    
              <div class="box-footer">
                      @csrf
                  <div class="col-md-2"></div>
                  <div class="col-md-8">
                      <div class="btn-group pull-right">
                          <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                      </div>
                      <div class="btn-group pull-left">
                          <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
                      </div>
                  </div>   
              <!-- /.box-footer -->
              </div>
        </form>
          <!-- /.box-body -->
      </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">

    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{!! $title ?? '' !!}</h3>
        @if ($layout == 'edit')
        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 5px">
                <a href="{{ route('admin_language.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
            </div>
        </div>
        @endif
      </div>

      <div class="box-body table-responsive box-primary">
        <div class="box-header with-border">
          <div class="box-body no-padding" >
            <section id="pjax-container" class="table-list">
              <div class="box-body table-responsive no-padding" >
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
                            <tr>
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
              </div>
              <div class="box-footer clearfix">
                 {!! $resultItems??'' !!}
                 {!! $pagination??'' !!}
              </div>
             </section>
      </div>
      </div>
    </div>
  </div>

</div>
</div>
@endsection


@push('styles')
<style type="text/css">
  .box-body td,.box-body th{
  max-width:150px;word-break:break-all;
}
</style>
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
        var url = '{{ $urlSort??'' }}?sort_order='+$('#order_sort option:selected').val();
        $.pjax({url: url, container: '#pjax-container'})
      });
    @endif
    

    $(document).on('ready pjax:end', function(event) {
      $('.table-list input').iCheck({
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
                      window.location.replace('{{ route('admin_language.index') }}');
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
