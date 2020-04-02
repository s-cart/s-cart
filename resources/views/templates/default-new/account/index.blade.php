@php
/*
$layout_page = shop_profile
$user
*/ 
@endphp

@extends($templatePath.'.layout')

@section('main')
<div class="container">
    <div class="row">
        {{-- <div class="col-12">
            <h2 class="title-page">{{ trans('account.my_profile') }}</h2>
    </div> --}}
    <div class="col-12 col-sm-12 col-md-3">
        @include($templatePath.'.account.nav_customer')
    </div>
    <div class="col-12 col-sm-12 col-md-9">
        <div class="card">
            <div class="card-body min-height-37vh member-index">
                <p>Wellcome <span> {{$user['first_name']}} {{$user['last_name']}}</span>!</p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('breadcrumb')
<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li><a href="{{ route('home') }}">{{ trans('front.home') }}</a></li>
        <li class="active">{{ $title }}</li>
    </ol>
</div>
@endsection