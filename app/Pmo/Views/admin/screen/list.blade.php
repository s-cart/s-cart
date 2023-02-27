@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
  <div class="col-12">
    <div class="card" >
      <div class="card-header with-border">
        <div class="card-tools">
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
        <div class="float-left">
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

      <div class="card-header with-border">
        <div class="card-tools">
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


         <div class="float-left">
          @if (!empty($removeList))
            <div class="menu-left">
              <button type="button" class="btn btn-default grid-select-all"><i class="far fa-square"></i></button>
            </div>
            <div class="menu-left">
              <span class="btn btn-flat btn-danger grid-trash" title="{{ sc_language_render('action.delete') }}"><i class="fas fa-trash-alt"></i></span>
            </div>
          @endif

          @if (!empty($buttonRefresh))
            <div class="menu-left">
              <span class="btn btn-flat btn-primary grid-refresh" title="{{ sc_language_render('action.refresh') }}"><i class="fas fa-sync-alt"></i></span>
            </div>
          @endif

          @if (!empty($buttonSort))
          <div class="menu-left">
            <div class="input-group float-right ml-1" style="width: 350px;">
              <div class="btn-group">
                <select class="form-control rounded-0 float-right" id="order_sort">
                {!! $optionSort??'' !!}
                </select>
              </div>
              <div class="input-group-append">
                  <button id="button_sort" type="submit" class="btn btn-primary"><i class="fas fa-sort-amount-down-alt"></i></button>
              </div>
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


      <!-- /.card-header -->
      <div class="card-body p-0" id="pjax-container">
        @php
            $urlSort = $urlSort ?? '';
        @endphp
        <div id="url-sort" data-urlsort="{!! strpos($urlSort, "?")?$urlSort."&":$urlSort."?" !!}"  style="display: none;"></div>
        <div class="table-responsive">
        <table class="table table-hover box-body text-wrap table-bordered">
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
                  <input class="checkbox grid-row-checkbox" type="checkbox" data-id="{{ $keyRow }}">
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
        
        <div class="block-pagination clearfix m-10">
          <div class="ml-3 float-left">
            {!! $resultItems??'' !!}
          </div>
          <div class="pagination pagination-sm mr-3 float-right">
            {!! $pagination??'' !!}
          </div>
        </div>

      </div>
      <!-- /.card-body -->

      <div class="card-footer clearfix">
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
      </div>


    </div>
    <!-- /.card -->
  </div>
</div>
@endsection


@push('styles')
{!! $css ?? '' !!}
@endpush

@push('scripts')
    {{-- //Pjax --}}
   <script src="{{ sc_file('admin/plugin/jquery.pjax.js')}}"></script>

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
        var url = $('#url-sort').data('urlsort')+'sort_order='+$('#order_sort option:selected').val();
        $.pjax({url: url, container: '#pjax-container'})
      });
    @endif

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
    title: '{{ sc_language_render('action.delete_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
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
                      alertMsg('error', data.msg, '{{ sc_language_render('action.warning') }}');
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
      alertMsg('success', '{{ sc_language_render('action.delete_confirm_deleted_msg') }}', '{{ sc_language_render('action.delete_confirm_deleted') }}');
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


function cloneProduct(id){
  Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  }).fire({
    title: '{{ sc_language_render('product.admin.clone_confirm') }}',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: '{{ sc_language_render('action.confirm_yes') }}',
    confirmButtonColor: "#DD6B55",
    cancelButtonText: '{{ sc_language_render('action.confirm_no') }}',
    reverseButtons: true,

    preConfirm: function() {
        return new Promise(function(resolve) {
            $.ajax({
                method: 'post',
                url: '{{ sc_route_admin('admin_product.clone') }}',
                data: {
                  pId:id,
                  _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    if(data.error == 1){
                      alertMsg('error', data.msg, '{{ sc_language_render('action.warning') }}');
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
      alertMsg('success', '{{ sc_language_render('product.admin.clone_success') }}', '');
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
