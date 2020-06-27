@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-md-12">
         <div class="box">
      <div class="box-header with-border">
        <div class="pull-right">
          @if (!empty($topMenuRight) && count($topMenuRight))
            @foreach ($topMenuRight as $item)
                <div class="menu-right">
                  @php
                      $arrCheck = explode('view::', $item);
                  @endphp
                  @if (count($arrCheck) == 2)
                    @if (view()->exists($arrCheck[1]))
                      @include($arrCheck[1])
                    @endif
                  @else
                    {!! trim($item) !!}
                  @endif
                </div>
            @endforeach
          @endif
        </div>
        <div class="pull-left">
          @if (!empty($topMenuLeft) && count($topMenuLeft))
            @foreach ($topMenuLeft as $item)
                <div class="menu-left">
                  @php
                  $arrCheck = explode('view::', $item);
                  @endphp
                  @if (count($arrCheck) == 2)
                    @if (view()->exists($arrCheck[1]))
                      @include($arrCheck[1])
                    @endif
                  @else
                    {!! trim($item) !!}
                  @endif
                </div>
            @endforeach
          @endif
         </div>
        <!-- /.box-tools -->
      </div>

      <div class="box-header with-border">
         <div class="pull-right">
           @if (!empty($menuRight) && count($menuRight))
             @foreach ($menuRight as $item)
                 <div class="menu-right">
                  @php
                      $arrCheck = explode('view::', $item);
                  @endphp
                  @if (count($arrCheck) == 2)
                    @if (view()->exists($arrCheck[1]))
                      @include($arrCheck[1])
                    @endif
                  @else
                    {!! trim($item) !!}
                  @endif
                 </div>
             @endforeach
           @endif
         </div>


         <div class="pull-left">
          @if (!empty($removeList))
            <div class="menu-left">
              <button type="button" class="btn btn-default grid-select-all"><i class="fa fa-square-o"></i></button>
            </div>
            <div class="menu-left">
              <a class="btn btn-flat btn-danger grid-trash" title="{{ trans('admin.delete') }}"><i class="fa fa-trash-o"></i></a>
            </div>
          @endif

          @if (!empty($buttonRefresh))
            <div class="menu-left">
              <a class="btn btn-flat btn-primary grid-refresh" title="{{ trans('admin.refresh') }}"><i class="fa fa-refresh"></i></a>
            </div>
          @endif

          @if (!empty($buttonSort))
          <div class="menu-left">
            <div class="btn-group">
                  <select class="form-control" id="order_sort">
                  {!! $optionSort??'' !!}
                  </select>
            </div>
            <div class="btn-group">
              <a class="btn btn-flat btn-primary" title="{{ trans('admin.sort') }}" id="button_sort">
                <i class="fa fa-sort-amount-asc"></i>
              </a>
            </div>
          </div>
          @endif

          @if (!empty($menuLeft) && count($menuLeft))
            @foreach ($menuLeft as $item)
                <div class="menu-left">
                  @php
                      $arrCheck = explode('view::', $item);
                  @endphp
                  @if (count($arrCheck) == 2)
                    @if (view()->exists($arrCheck[1]))
                      @include($arrCheck[1])
                    @endif
                  @else
                    {!! trim($item) !!}
                  @endif
                </div>
            @endforeach
          @endif

        </div>

      </div>
      <!-- /.box-header -->
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

      @if (!empty($blockBottom) && count($blockBottom))
        @foreach ($blockBottom as $item)
          <div class="clearfix">
            @php
            $arrCheck = explode('view::', $item);
            @endphp
            @if (count($arrCheck) == 2)
                                    @if (view()->exists($arrCheck[1]))
                      @include($arrCheck[1])
                    @endif
            @else
              {!! trim($item) !!}
            @endif
          </div>    
        @endforeach
      @endif
      
    </section>
      <!-- /.box-body -->
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
