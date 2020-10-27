@php
/*
$layout_page = shop_profile
** Variables:**
- $customer
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<div class="container">
    <div class="row">
        {{-- <div class="col-12">
            <h2 class="title-page">{{ trans('account.my_profile') }}</h2>
    </div> --}}
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
@endsection

@section('breadcrumb')
<section class="breadcrumbs-custom">
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
            <li class="active">{{ $title ?? '' }}</li>
          </ul>
        </div>
    </div>
</section>
@endsection