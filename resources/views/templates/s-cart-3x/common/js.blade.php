<script type="text/javascript">
  function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
  }
  $('#shipping').change(function(){
    $('#total').html(formatNumber(parseInt({{ Cart::subtotal() }})+ parseInt($('#shipping').val())));
  });
</script>


<script src="//cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"></script>

<!--process cart-->
<script type="text/javascript">
  function addToCartAjax(id,instance = null){
    $.ajax({
        url: "{{ route('cart.add_ajax') }}",
        type: "POST",
        dataType: "JSON",
        data: {"id": id,"instance":instance, "_token":"{{ csrf_token() }}"},
        async: false,
        success: function(data){
          // console.log(data);
            error = parseInt(data.error);
            if(error ==0)
            {
              setTimeout(function () {
                if(data.instance =='default'){
                  $('.sc-cart').html(data.count_cart);
                }else{
                  $('.sc-'+data.instance).html(data.count_cart);
                }
              }, 1000);

                $.notify({
                  icon: 'fa fa-star',
                  message: data.msg
                },{
                  type: 'success',
                  z_index: 1080,
                  offset: 30
                },
                );
            }else{
              if(data.redirect){
                window.location.replace(data.redirect);
                return;
              }
              $.notify({
              icon: 'fa fa-exclamation-circle',
                message: data.msg
              },{
                type: 'danger',
                z_index: 1080,
                offset: 30
              });
            }

            }
    });
  }
</script>
<!--//end cart -->


<!--message-->
@if(Session::has('success'))
<script type="text/javascript">
    $.notify({
      icon: 'fa fa-star',
      message: "{!! Session::get('success') !!}"
    },{
      type: 'success',
      z_index: 1080,
      offset: 30
    });
</script>
@endif

@if(Session::has('error'))
<script type="text/javascript">
    $.notify({
      icon: 'fa fa-exclamation-circle',
      message: "{!! Session::get('error') !!}"
    },{
      type: 'danger',
      z_index: 1080,
      offset: 30
    });
</script>
@endif

@if(Session::has('warning'))
<script type="text/javascript">
    $.notify({
      icon: 'fa fa-exclamation-circle',
      message: "{!! Session::get('warning') !!}"
    },{
      type: 'warning',
      z_index: 1080,
      offset: 30
    });
</script>
@endif
<!--//message-->
