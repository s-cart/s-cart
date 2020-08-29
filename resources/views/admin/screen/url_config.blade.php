@extends('admin.layout')

@section('main')

<div class="row">

  <div class="col-md-12">

    <div class="card">
      <div class="card-body table-responsive">
       <table class="table table-hover">
         <thead>
           <tr>
             <th>{{ trans('env.field') }}</th>
             <th>{{ trans('env.value') }}</th>
           </tr>
         </thead>
         <tbody>

          <tr>
            <td>{{ trans('env.SUFFIX_URL') }}</td>
            <td><a href="#" class="updateInfo editable editable-click" data-name="SUFFIX_URL" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.SUFFIX_URL') }}" data-value="{{ sc_config('SUFFIX_URL') }}" data-original-title="" title=""></a></td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_SHOP') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_SHOP" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_SHOP') }}" data-value="{{ sc_config('PREFIX_SHOP') }}" data-original-title="" title=""></a></td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_PRODUCT') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_PRODUCT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_PRODUCT') }}" data-value="{{ sc_config('PREFIX_PRODUCT') }}" data-original-title="" title=""></a>/name-of-product{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_CATEGORY') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CATEGORY') }}" data-value="{{ sc_config('PREFIX_CATEGORY') }}" data-original-title="" title=""></a>/name-of-category{{ sc_config('SUFFIX_URL') }}</td>
          </tr>
          
          <tr>
            <td>{{ trans('env.PREFIX_BRAND') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_BRAND" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_BRAND') }}" data-value="{{ sc_config('PREFIX_BRAND') }}" data-original-title="" title=""></a>/name-of-brand{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_SUPPLIER') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_SUPPLIER" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_SUPPLIER') }}" data-value="{{ sc_config('PREFIX_SUPPLIER') }}" data-original-title="" title=""></a>/name-of-supplier{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_SEARCH') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_SEARCH" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_SEARCH') }}" data-value="{{ sc_config('PREFIX_SEARCH') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_CONTACT') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CONTACT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CONTACT') }}" data-value="{{ sc_config('PREFIX_CONTACT') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_NEWS') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_NEWS" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_NEWS') }}" data-value="{{ sc_config('PREFIX_NEWS') }}" data-original-title="" title=""></a>/name-of-blog-news{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_MEMBER') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER') }}" data-value="{{ sc_config('PREFIX_MEMBER') }}" data-original-title="" title=""></a>/page-name-member{{ sc_config('SUFFIX_URL') }}</td>
          </tr>         

          <tr>
            <td>{{ trans('env.PREFIX_MEMBER_ORDER_LIST') }}</td>
            <td>https://your-domain.com/{{ sc_config('PREFIX_MEMBER') }}/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER_ORDER_LIST" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER_ORDER_LIST') }}" data-value="{{ sc_config('PREFIX_MEMBER_ORDER_LIST') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>    

          <tr>
            <td>{{ trans('env.PREFIX_MEMBER_CHANGE_PWD') }}</td>
            <td>https://your-domain.com/{{ sc_config('PREFIX_MEMBER') }}/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER_CHANGE_PWD" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER_CHANGE_PWD') }}" data-value="{{ sc_config('PREFIX_MEMBER_CHANGE_PWD') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_MEMBER_CHANGE_INFO') }}</td>
            <td>https://your-domain.com/{{ sc_config('PREFIX_MEMBER') }}/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_MEMBER_CHANGE_INFO" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_MEMBER_CHANGE_INFO') }}" data-value="{{ sc_config('PREFIX_MEMBER_CHANGE_INFO') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_CMS_CATEGORY') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CMS_CATEGORY" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CMS_CATEGORY') }}" data-value="{{ sc_config('PREFIX_CMS_CATEGORY') }}" data-original-title="" title=""></a>/name-of-cms-categoyr{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_CMS_ENTRY') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CMS_ENTRY" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CMS_ENTRY') }}" data-value="{{ sc_config('PREFIX_CMS_ENTRY') }}" data-original-title="" title=""></a>/name-of-entry-cms{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_CART_WISHLIST') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_WISHLIST" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_WISHLIST') }}" data-value="{{ sc_config('PREFIX_CART_WISHLIST') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>

          <tr>
            <td>{{ trans('env.PREFIX_CART_COMPARE') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_COMPARE" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_COMPARE') }}" data-value="{{ sc_config('PREFIX_CART_COMPARE') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr>          

          <tr>
            <td>{{ trans('env.PREFIX_CART_DEFAULT') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_DEFAULT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_DEFAULT') }}" data-value="{{ sc_config('PREFIX_CART_DEFAULT') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr> 

          <tr>
            <td>{{ trans('env.PREFIX_CART_CHECKOUT') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_CART_CHECKOUT" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_CART_CHECKOUT') }}" data-value="{{ sc_config('PREFIX_CART_CHECKOUT') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
          </tr> 

          <tr>
            <td>{{ trans('env.PREFIX_ORDER_SUCCESS') }}</td>
            <td>https://your-domain.com/<a href="#" class="fied-required editable editable-click" data-name="PREFIX_ORDER_SUCCESS" data-type="text" data-pk="" data-source="" data-url="{{ route('admin_config.update') }}" data-title="{{ trans('env.PREFIX_ORDER_SUCCESS') }}" data-value="{{ sc_config('PREFIX_ORDER_SUCCESS') }}" data-original-title="" title=""></a>{{ sc_config('SUFFIX_URL') }}</td>
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
<link rel="stylesheet" href="{{ asset('admin/plugin/bootstrap-editable.css')}}">
@endpush

@push('scripts')
<!-- Ediable -->
<script src="{{ asset('admin/plugin/bootstrap-editable.min.js')}}"></script>

<script type="text/javascript">
  // Editable
$(document).ready(function() {
      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };
       $('.updateInfo').editable({});
        $('.fied-required').editable({
        validate: function(value) {
            if (value == '') {
                return '{{  trans('admin.not_empty') }}';
            }
        },
        success: function(data) {
          if(data.error == 0){
            if(data.field == 'ADMIN_PREFIX'){
              window.location.replace("/"+data.value+'/env');
            }
            alertJs('success','{{ trans('admin.msg_change_success') }}');
          } else {
            alertJs('error', data.msg);
          }
      }
    });
});
</script>

    {{-- //Pjax --}}
   <script src="{{ asset('admin/plugin/jquery.pjax.js')}}"></script>

  <script type="text/javascript">

    $('.grid-refresh').click(function(){
      $.pjax.reload({container:'#pjax-container'});
    });

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

    {!! $script_sort??'' !!}

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
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success',
      cancelButton: 'btn btn-danger'
    },
    buttonsStyling: true,
  })

  swalWithBootstrapButtons.fire({
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
                    $.pjax.reload('#pjax-container');
                    resolve(data);
                }
            });
        });
    }

  }).then((result) => {
    if (result.value) {
      swalWithBootstrapButtons.fire(
        '{{ trans('admin.confirm_delete_deleted') }}',
        '{{ trans('admin.confirm_delete_deleted_msg') }}',
        'success'
      )
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

@endpush
