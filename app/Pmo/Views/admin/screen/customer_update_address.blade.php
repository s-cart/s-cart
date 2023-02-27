@extends($templatePathAdmin.'layout')

@section('main')
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr-5">
                            <a href="{{ sc_route_admin('admin_customer.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{ sc_language_render('admin.back_list') }}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                        <div class="fields-group">

                            @if (sc_config_admin('customer_lastname'))
                            <div class="form-group row {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.first_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="first_name" type="text" class="form-control" name="first_name" required
                                        value="{{ (old('first_name', $address['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="form-text">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('last_name') ? ' text-red' : '' }}">
                                <label for="last_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.last_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="last_name" type="text" class="form-control" name="last_name" required
                                        value="{{ (old('last_name', $address['last_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('last_name'))
                                    <span class="form-text">{{ $errors->first('last_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('first_name') ? ' text-red' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="first_name" type="text" class="form-control" name="first_name" required
                                        value="{{ (old('first_name', $address['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="form-text">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config_admin('customer_phone'))
                            <div class="form-group row {{ $errors->has('phone') ? ' text-red' : '' }}">
                                <label for="phone"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.phone') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="phone" type="text" class="form-control" name="phone" required
                                        value="{{ (old('phone', $address['phone'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('phone'))
                                    <span class="form-text">{{ $errors->first('phone') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config_admin('customer_postcode'))
                            <div class="form-group row {{ $errors->has('postcode') ? ' text-red' : '' }}">
                                <label for="postcode"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.postcode') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="postcode" type="text" class="form-control" name="postcode" required
                                        value="{{ (old('postcode', $address['postcode'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('postcode'))
                                    <span class="form-text">{{ $errors->first('postcode') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    

                            <div class="form-group row {{ $errors->has('address1') ? ' text-red' : '' }}">
                                <label for="address1"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.address1') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="address1" type="text" class="form-control" name="address1" required
                                        value="{{ (old('address1', $address['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address1'))
                                    <span class="form-text">{{ $errors->first('address1') }}</span>
                                    @endif
    
                                </div>
                            </div>

                            @if (sc_config_admin('customer_address2'))
                            <div class="form-group row {{ $errors->has('address2') ? ' text-red' : '' }}">
                                <label for="address2"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.address2') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="address2" type="text" class="form-control" name="address2" required
                                        value="{{ (old('address2', $address['address2'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address2'))
                                    <span class="form-text">{{ $errors->first('address2') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config_admin('customer_address3'))
                            <div class="form-group row {{ $errors->has('address3') ? ' text-red' : '' }}">
                                <label for="address3"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.address3') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="address3" type="text" class="form-control" name="address3" required
                                        value="{{ (old('address3', $address['address3'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address3'))
                                    <span class="form-text">{{ $errors->first('address3') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif


                            @if (sc_config_admin('customer_country'))
                            @php
                            $country = old('country', $address['country'] ?? '');
                            @endphp
    
                            <div class="form-group row {{ $errors->has('country') ? ' text-red' : '' }}">
                                <label for="country"
                                    class="col-sm-2 col-form-label">{{ sc_language_render('customer.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control country" style="width: 100%;" name="country">
                                        <option>__{{ sc_language_render('customer.country') }}__</option>
                                        @foreach ($countries as $k => $v)
                                        <option value="{{ $k }}" {{ ($country == $k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                    <span class="form-text">
                                        {{ $errors->first('country') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if ($address->id != $customer->address_id)
                            <div class="form-group row">
                                <label for="default"
                                    class="col-md-2 col-form-label">{{ sc_language_render('customer.chose_address_default') }}</label>
                                <div class="col-md-8">
                                    <input id="default" type="checkbox" name="default">
                                </div>
                            </div>
                            @endif


                        </div>
                    </div>



                    <!-- /.card-body -->

                    <div class="card-footer row">
                        @csrf
                        <div class="col-md-2">
                        </div>
    
                        <div class="col-md-8">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary">{{ sc_language_render('action.submit') }}</button>
                            </div>
    
                            <div class="btn-group float-left">
                                <button type="reset" class="btn btn-warning">{{ sc_language_render('action.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->
                </form>

            </div>

        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')

@endpush
