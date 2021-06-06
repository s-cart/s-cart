@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
    <div class="container">
            <div class="row">
            <div class="col-12 col-sm-12 col-md-3">
                @include($sc_templatePath.'.account.nav_customer')
            </div>
            <div class="col-12 col-sm-12 col-md-9">
                <div class="card">
                    <div class="card-body min-height-37vh member-index">
                        <p>Wellcome <span> {{ $customer['first_name'] }} {{ $customer['last_name'] }}</span>!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection