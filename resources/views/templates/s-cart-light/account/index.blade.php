@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.account.layout')

@section('block_main_profile')
    <p>Wellcome <span> {{ $customer['first_name'] }} {{ $customer['last_name'] }}</span>!</p>
@endsection