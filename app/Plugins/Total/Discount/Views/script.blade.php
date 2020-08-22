$('#coupon-button').click(function() {
    var coupon = $('#coupon-value').val();
       if(coupon==''){
           $('#coupon-group').addClass('has-error');
           $('.coupon-msg').html('{{ trans('cart.coupon_empty') }}').addClass('text-danger').show();
       }else{
       $('#coupon-button').button('loading');
       setTimeout(function() {
           $.ajax({
               url: '{{ sc_route('discount.process') }}',
               type: 'POST',
               dataType: 'json',
               data: {
                   code: coupon,
                   uID: {{ auth()->user()->id ?? 0 }},
                   _token: "{{ csrf_token() }}",
               },
           })
           .done(function(result) {
                   $('#coupon-value').val('');
                   $('.coupon-msg').removeClass('text-danger');
                   $('.coupon-msg').removeClass('text-success');
                   $('#coupon-group').removeClass('has-error');
                   $('.coupon-msg').hide();
               if(result.error ==1){
                   $('#coupon-group').addClass('has-error');
                   $('.coupon-msg').html(result.msg).addClass('text-danger').show();
               }else{
                   $('#removeCoupon').show();
                   $('.coupon-msg').html(result.msg).addClass('text-success').show();
                   $('.showTotal').remove();
                   $('#showTotal').prepend(result.html);
               }
           })
           .fail(function() {
               console.log("error");
           })
          $('#coupon-button').button('reset');
      }, 2000);
       }

   });
   $('#removeCoupon').click(function() {
           $.ajax({
               url: '{{ sc_route('discount.remove') }}',
               type: 'POST',
               dataType: 'json',
               data: {
                   _token: "{{ csrf_token() }}",
               },
           })
           .done(function(result) {
                   $('#removeCoupon').hide();
                   $('#coupon-value').val('');
                   $('.coupon-msg').removeClass('text-danger');
                   $('.coupon-msg').removeClass('text-success');
                   $('.coupon-msg').hide();
                   $('.showTotal').remove();
                   $('#showTotal').prepend(result.html);
           })
           .fail(function() {
               console.log("error");
           })
   });