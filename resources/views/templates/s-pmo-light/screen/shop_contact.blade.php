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
            <img src="{{ sc_file(sc_store('logo')) }}">
            <address>
                <p>{{ sc_store('title') }}</p>
                <p><span class="icon mdi mdi-map-marker"></span> {{ sc_store('address') }}</p>
                <p><span class="icon mdi mdi-phone"></span> {{ sc_store('long_phone') }}</p>
                <p><span class="icon mdi mdi-email-outline"></span> {{ sc_store('email') }}</p>
            </address>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <form method="post" action="{{ sc_route('contact.post') }}" class="contact-form" id="sc_form-process">
                {{ csrf_field() }}
                <div id="contactFormWrapper">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label>{{ sc_language_render('contact.name') }}:</label>
                            <input type="text" class="form-control {{ ($errors->has('name'))?"input-error":"" }}"
                                name="name" placeholder="{{ sc_language_render('contact.name') }}" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                {{ $errors->first('name') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label>{{ sc_language_render('contact.email') }}:</label>
                            <input type="email" class="form-control {{ ($errors->has('email'))?"input-error":"" }}"
                                name="email" placeholder="{{ sc_language_render('contact.email') }}" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label>{{ sc_language_render('contact.phone') }}:</label>
                            <input type="telephone" class="form-control {{ ($errors->has('phone'))?"input-error":"" }}"
                                name="phone" placeholder="{{ sc_language_render('contact.phone') }}" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                            <span class="help-block">
                                {{ $errors->first('phone') }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="control-label">{{ sc_language_render('contact.subject') }}:</label>
                            <input type="text" class="form-control {{ ($errors->has('title'))?"input-error":"" }}"
                                name="title" placeholder="{{ sc_language_render('contact.subject') }}" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <span class="help-block">
                                {{ $errors->first('title') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 form-group {{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="control-label">{{ sc_language_render('contact.content') }}:</label>
                            <textarea class="form-control {{ ($errors->has('content'))?"input-error":"" }}" rows="5"
                                cols="75" name="content" placeholder="{{ sc_language_render('contact.content') }}">{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                            <span class="help-block">
                                {{ $errors->first('content') }}
                            </span>
                            @endif

                        </div>
                    </div>

                    {!! $viewCaptcha?? '' !!}

                    {{-- Button submit --}}
                    <div class="btn-toolbar form-group">
                        @php
                        $dataButton = [
                                'class' => '', 
                                'id' =>  'sc_button-form-process',
                                'type_w' => '',
                                'type_t' => 'buy',
                                'type_a' => '',
                                'type' => 'submit',
                                'name' => ''.sc_language_render('action.submit'),
                                'html' => ''
                            ];
                        @endphp
                        @include($sc_templatePath.'.common.button.button', $dataButton)

                    </div>
                    {{--// Button submit --}}
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@endsection


@push('styles')
{{-- Your css style --}}
@endpush

@push('scripts')
{{-- //script here --}}
@endpush