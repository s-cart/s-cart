
<script type="text/javascript">

  $(function () {
    $('.input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

</script>

{{-- image file manager --}}
<script type="text/javascript">
(function( $ ){

      $.fn.filemanager = function(type, options) {
        type = type || 'other';

        this.on('click', function(e) {
          type = $(this).data('type') || type;//sc
          var route_prefix = (options && options.prefix) ? options.prefix : '{{ route('admin.home').'/'.config('lfm.url_prefix') }}';
          var target_input = $('#' + $(this).data('input'));
          var target_preview = $('#' + $(this).data('preview'));
          window.open(route_prefix + '?type=' + type, '{{ trans('admin.file_manager') }}', 'width=900,height=600');
          window.SetUrl = function (items) {
            var file_path = items.map(function (item) {
              return item.url;
            }).join(',');

            // set the value of the desired input to image url
            target_input.val('').val(file_path).trigger('change');

            // clear previous preview
            target_preview.html('');

            // set or change the preview image src
            items.forEach(function (item) {
              target_preview.append(
                $('<img>').attr('src', item.thumb_url)
              );
            });

            // trigger change event
            target_preview.trigger('change');
          };
          return false;
        });
      }

    })(jQuery);

    $('.lfm').filemanager();
</script>
{{-- //image file manager --}}


<script type="text/javascript">
// Select row
  $(function () {
    //Enable check and uncheck all functionality
    $(".grid-select-all").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".box-body input[type='checkbox']").iCheck("uncheck");
        $(".far", this).removeClass("fa-check-square").addClass('fa-square');
      } else {
        //Check all checkboxes
        $(".box-body input[type='checkbox']").iCheck("check");
        $(".far", this).removeClass("fa-square").addClass('fa-check-square');
      }
      $(this).data("clicks", !clicks);
    });

  });
// == end select row

  function format_number(n) {
      return n.toFixed(0).replace(/./g, function(c, i, a) {
          return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
      });
  }

// active tree menu
$('.nav-treeview > li.active').parents('.has-treeview').addClass('active menu-open');
// ==end active tree menu

</script>

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";

    function alertJs(type = 'error', msg = '') {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      Toast.fire({
        type: type,
        title: msg
      })
    }

    function alertMsg(type = 'error', msg = '', note = '') {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true,
      });
      swalWithBootstrapButtons.fire(
        msg,
        note,
        type
      )
    }

    function alertConfirm(type = 'warning', msg = '') {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
      Toast.fire({
        type: type,
        title: msg
      })
    }
    
</script>
