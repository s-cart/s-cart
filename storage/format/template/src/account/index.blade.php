@php
/*
$layout_page = shop_profile
$user
*/ 
@endphp

@extends($sc_templatePath.'.layout')

@section('main')
<section >
<div class="container">
    <div class="row">
        <h2 class="title text-center">{{ trans('account.my_profile') }}</h2>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{ sc_route('member.change_password') }}">{{ trans('account.change_password') }}</a></li>
            <li class="list-group-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{ sc_route('member.change_infomation') }}">{{ trans('account.change_infomation') }}</a></li>
            <li class="list-group-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{ sc_route('member.order_list') }}">{{ trans('account.order_list') }}</a></li>
        </ul>
    </div>
</div>
</section>
@endsection

@section('breadcrumb')
    <div class="breadcrumbs">
        <ol class="breadcrumb">
          <li><a href="{{ sc_route('home') }}">{{ trans('front.home') }}</a></li>
          <li class="active">{{ $title }}</li>
        </ol>
      </div>
@endsection

@push('styles')
      {{-- style css --}}
@endpush

@push('scripts')
      {{-- script --}}
@endpush
