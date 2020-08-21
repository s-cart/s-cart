@php
/*
$layout_page = shop_contact
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-sm section-first bg-default text-md-left">
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 contact_content">
            <img src="{{ asset(sc_store('logo')) }}">
            <address>
                <p>{{ sc_store('title') }}</p>
                <p>{{ sc_store('address') }}</p>
                <p>{{ sc_store('long_phone') }}</p>
                <p>{{ sc_store('email') }}</p>
            </address>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <form method="post" action="{{ sc_route('contact.post') }}" class="contact-form">
                {{ csrf_field() }}
                <div id="contactFormWrapper">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label>{{ trans('front.contact_form.name') }}:</label>
                            <input type="text" class="form-control {{ ($errors->has('name'))?"input-error":"" }}"
                                name="name" placeholder="{{ trans('front.contact_form.name') }}" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                {{ $errors->first('name') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>{{ trans('front.contact_form.email') }}:</label>
                            <input type="email" class="form-control {{ ($errors->has('email'))?"input-error":"" }}"
                                name="email" placeholder="{{ trans('front.contact_form.email') }}" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label>{{ trans('front.contact_form.phone') }}:</label>
                            <input type="telephone" class="form-control {{ ($errors->has('phone'))?"input-error":"" }}"
                                name="phone" placeholder="{{ trans('front.contact_form.phone') }}" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                            <span class="help-block">
                                {{ $errors->first('phone') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="control-label">{{ trans('front.contact_form.subject') }}:</label>
                            <input type="text" class="form-control {{ ($errors->has('title'))?"input-error":"" }}"
                                name="title" placeholder="{{ trans('front.contact_form.subject') }}" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                {{ $errors->first('title') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="control-label">{{ trans('front.contact_form.content') }}:</label>
                            <textarea class="form-control {{ ($errors->has('content'))?"input-error":"" }}" rows="5"
                                cols="75" name="content" placeholder="{{ trans('front.contact_form.content') }}">{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                            <span class="help-block">
                                {{ $errors->first('content') }}
                            </span>
                            @endif

                        </div>
                    </div>
                    <div class="btn-toolbar form-group">
                        <input type="submit" value="{{ trans('front.contact_form.submit') }}" class="button button-lg button-secondary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
@endsection

{{-- breadcrumb --}}
@section('breadcrumb')
@php
$bannerBreadcrumb = $modelBanner->start()->getBannerBreadcrumb()->getData()->first();
@endphp
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{ asset($bannerBreadcrumb['image'] ?? '') }}">
    <div class="material-parallax parallax"><img src="{{ asset($bannerBreadcrumb['image'] ?? '') }}" alt="" style="display: block; transform: translate3d(-50%, 83px, 0px);"></div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">{{ $title ?? '' }}</h2>
      </div>
    </div>
  </div>
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
{{-- //breadcrumb --}}