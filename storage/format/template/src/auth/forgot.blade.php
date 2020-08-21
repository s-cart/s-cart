@php
/*
$layout_page = shop_auth
*/
@endphp


@extends($sc_templatePath.'.layout')

@section('main')
<div class="row">
        <div class="container">
                <h2 class="title text-center">{{ $title }}</h2>
                <div class="col-md-3">
                </div>
                    <div class="col-md-6 login-form">
                     @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ sc_route('password.email') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{ trans('customer.email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <button type="submit" name="SubmitLogin" class="btn btn-default">
                                    <span>
                                    <i class="glyphicon glyphicon-wrench"></i>
                                       {{ trans('front.submit_form') }}
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
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