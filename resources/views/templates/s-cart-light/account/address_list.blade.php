@php
/*
$layout_page = shop_profile
** Variables:**
- $addresses
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<style>
  .list{
    padding: 5px;
    border-bottom: 1px solid #c5baba;
  }
</style>
<section class="section section-sm section-first bg-default text-md-left">
<div class="container">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-3">
      @include($sc_templatePath.'.account.nav_customer')
    </div>
    <div class="col-md-9 ">
      <h6 class="aside-title">{{ $title }}</h6>
      @if (count($addresses) ==0)
      <div class="text-danger">
        {{ sc_language_render('front.data_notfound') }}
      </div>
      @else
          @foreach($addresses as $address)
              <div class="list">
                @if (sc_config('customer_lastname'))
                <b>{{ sc_language_render('customer.first_name') }}:</b> {{ $address['first_name'] }}<br>
                <b>{{ sc_language_render('customer.last_name') }}:</b> {{ $address['last_name'] }}<br>
                @else
                <b>{{ sc_language_render('customer.name') }}:</b> {{ $address['first_name'] }}<br>
                @endif
                
                @if (sc_config('customer_phone'))
                <b>{{ sc_language_render('customer.phone') }}:</b> {{ $address['phone'] }}<br>
                @endif

                @if (sc_config('customer_postcode'))
                <b>{{ sc_language_render('customer.postcode') }}:</b> {{ $address['postcode'] }}<br>
                @endif

                <b>{{ sc_language_render('customer.address1') }}:</b> {{ $address['address1'] }}<br>

                @if (sc_config('customer_address2'))
                <b>{{ sc_language_render('customer.address2') }}:</b> {{ $address['address2'] }}<br>
                @endif

                @if (sc_config('customer_address3'))
                <b>{{ sc_language_render('customer.address3') }}:</b> {{ $address['address3'] }}<br>
                @endif

                @if (sc_config('customer_country'))
                <b>{{ sc_language_render('customer.country') }}:</b> {{ $countries[$address['country']] ?? $address['country'] }}<br>
                @endif

                <span class="btn">
                  <a title="{{ sc_language_render('action.edit') }}" href="{{ sc_route('customer.update_address', ['id' => $address->id]) }}"><i class="fas fa-edit"></i></a>
                </span>
                <span class="btn">
                  <a href="#" title="{{ sc_language_render('action.delete') }}" class="delete-address" data-id="{{ $address->id }}"><i class="fas fa-trash-alt"></i></a>
                </span>
                @if ($address->id == auth()->user()->address_id)
                <span class="btn" title="{{ sc_language_render('customer.address_default') }}"><i class="fas fa-university" aria-hidden="true"></i></span>
                @endif
              </div>
          @endforeach
      @endif
    </div>
  </div>
</div>
</section>
@endsection


{{-- breadcrumb --}}
@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ sc_language_render('front.home') }}</a></li>
            <li><a href="{{ sc_route('customer.index') }}">{{ sc_language_render('front.my_account') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection
{{-- //breadcrumb --}}



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