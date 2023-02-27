{{-- Need add under script of sweetaleart2 --}}
<!--message-->
    @if(session()->has('success'))

    <script type="text/javascript">
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'success',
        title: '{{ session('success') }}'
      })
    </script>
    @endif

    @if(session()->has('error'))
    <script type="text/javascript">
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'error',
        title: '{{ session('error') }}'
      })
    </script>
    @endif

    @if(session()->has('warning'))
    <script type="text/javascript">
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'warning',
        title: '{{ session('warning') }}'
      })
    </script>
    @endif
