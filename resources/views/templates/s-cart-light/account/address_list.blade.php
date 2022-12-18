@php
/*
$layout_page = shop_profile
** Variables:**
- $addresses
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
<style>
  .list{
    padding: 5px;
    border-bottom: 1px solid #c5baba;
  }
</style>
<h6 class="title-store">{{ $title }}</h6>
      @if (count($addresses) ==0)
      <div class="text-danger">
        {{ sc_language_render('front.no_item') }}
      </div>
      @else
          @foreach($addresses as $address)
              <div class="list">
                <table style="width:300px">
                  
                @if (sc_config('customer_lastname'))
                <tr><td><b>{{ sc_language_render('customer.first_name') }}:</b></td><td> {{ $address['first_name'] }}</td></tr>
                <tr><td><b>{{ sc_language_render('customer.last_name') }}:</td><td> {{ $address['last_name'] }}</td></tr>
                @else
                <tr><td><b>{{ sc_language_render('customer.name') }}:</td><td> {{ $address['first_name'] }}</td></tr>
                @endif
                
                @if (sc_config('customer_phone'))
                <tr><td><b>{{ sc_language_render('customer.phone') }}:</td><td> {{ $address['phone'] }}</td></tr>
                @endif

                @if (sc_config('customer_postcode'))
                <tr><td><b>{{ sc_language_render('customer.postcode') }}:</td><td> {{ $address['postcode'] }}</td></tr>
                @endif

                <tr><td><b>{{ sc_language_render('customer.address1') }}:</td><td> {{ $address['address1'] }}</td></tr>

                @if (sc_config('customer_address2'))
                <tr><td><b>{{ sc_language_render('customer.address2') }}:</td><td> {{ $address['address2'] }}</td></tr>
                @endif

                @if (sc_config('customer_address3'))
                <tr><td><b>{{ sc_language_render('customer.address3') }}:</td><td> {{ $address['address3'] }}</td></tr>
                @endif

                @if (sc_config('customer_country'))
                <tr><td><b>{{ sc_language_render('customer.country') }}:</td><td> {{ $countries[$address['country']] ?? $address['country'] }}</td></tr>
                @endif
                <tr><td colspan="2">
                <span class="btn">
                  <a title="{{ sc_language_render('action.edit') }}" href="{{ sc_route('customer.update_address', ['id' => $address->id]) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </span>
                <span class="btn">
                  <a href="#" title="{{ sc_language_render('action.delete') }}" class="delete-address" data-id="{{ $address->id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </span>
                @if ($address->id == auth()->user()->address_id)
                <span class="btn" title="{{ sc_language_render('customer.address_default') }}"><i class="fa fa-font-awesome" aria-hidden="true"></i></span>
                @endif
               </td></tr>
                </table>
              </div>
          @endforeach
      @endif
@endsection



@push('scripts')
<script>
  $('.delete-address').click(function(){
    var r = confirm("{{ sc_language_render('action.delete_confirm') }}");
    if(!r) {
      return;
    }
    var id = $(this).data('id');
    $.ajax({
            url:'{{ sc_route("member.delete_address") }}',
            type:'POST',
            dataType:'json',
            data:{id:id,"_token": "{{ csrf_token() }}"},
                beforeSend: function(){
                $('#loading').show();
            },
            success: function(data){
              if(data.error == 0) {
                location.reload();
              }
            }
        });
  });
</script>
@endpush