@php
/*
$layout_page = shop_contact
*/
@endphp

@extends($sc_templatePath.'.layout')

@section('block_main')

     <div id="contact-page" class="container">
        <div class="bg">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title text-center">{{ $title }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="contact-form">
                        <h2 class="title text-center">{{ trans('front.contact_form.title') }}</h2>
                        <form method="post" action="{{ sc_route('contact.post') }}" class="contact-form">
                        {{ csrf_field() }}
                        <div id="contactFormWrapper" style="margin: 30px;">
                        <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <div class="row">
                                        <div class="col-sm-4 form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                            <label>{{ trans('front.contact_form.name') }}:</label>
                                            <input type="text"  class="form-control {{ ($errors->has('name'))?"input-error":"" }}"  name="name" placeholder="Your name..." value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    {{ $errors->first('name') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label>{{ trans('front.contact_form.email') }}:</label>
                                            <input  type="email" class="form-control {{ ($errors->has('email'))?"input-error":"" }}"  name="email" placeholder="Your email..." value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-4 form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                            <label>{{ trans('front.contact_form.phone') }}:</label>
                                            <input  type="telephone" class="form-control {{ ($errors->has('phone'))?"input-error":"" }}"  name="phone" placeholder="Your phone..." value="{{ old('phone') }}">
                                            @if ($errors->has('phone'))
                                                <span class="help-block">
                                                    {{ $errors->first('phone') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label class="control-label">{{ trans('front.contact_form.subject') }}:</label>
                                            <input  type="text" class="form-control {{ ($errors->has('title'))?"input-error":"" }}"  name="title" placeholder="Subject..." value="{{ old('title') }}">
                                            @if ($errors->has('title'))
                                                <span class="help-block">
                                                    {{ $errors->first('title') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                                            <label class="control-label">{{ trans('front.contact_form.content') }}:</label>
                                            <textarea  class="form-control {{ ($errors->has('content'))?"input-error":"" }}" rows="5" cols="75"  name="content" placeholder="Your Message...">{{ old('content') }}</textarea>
                                            @if ($errors->has('content'))
                                                <span class="help-block">
                                                    {{ $errors->first('content') }}
                                                </span>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="btn-toolbar form-group">
                                        <input type="submit"  value="{{ trans('front.contact_form.submit') }}" class="btn btn-primary">
                                    </div>
                                </div>
                        </div>
                        </div><!-- contactFormWrapper -->
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="contact-info">
                        <h2 class="title text-center">{{ trans('front.contact_form.info') }}</h2>
                        <address>
                            <p>{{ sc_store('title') }}</p>
                            <p>{{ sc_store('address') }}</p>
                            <p>{{ sc_store('long_phone') }}</p>
                            <p>{{ sc_store('email') }}</p>
                        </address>
                        <div class="social-networks">
                            <h2 class="title text-center">Social Networking</h2>
                            <ul>
                                <li>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-youtube"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/#contact-page-->



  <!-- Main Container -->
  <div class="main-container col1-layout">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
  <div class="page_content">


  </div>
        </div>
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