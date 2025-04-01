<script type="text/javascript">
  function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  }
</script>
<script src="{{ gp247_file($GP247TemplateFile.'/js/sweetalert2.all.min.js') }}"></script>
<script>
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
</script>

<!--message-->
@if(Session::has('success'))
<script type="text/javascript">
    alertJs('success', '{!! Session::get('success') !!}');
</script>
@endif

@if(Session::has('error'))
<script type="text/javascript">
  alertJs('error', '{!! Session::get('error') !!}');
</script>
@endif

@if(Session::has('warning'))
<script type="text/javascript">
  alertJs('error', '{!! Session::get('warning') !!}');
</script>
@endif
<!--//message-->
