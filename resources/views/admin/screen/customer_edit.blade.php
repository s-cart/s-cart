@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-sm-12">
         <div class="box">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ $title_description??'' }}</h2>

                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 5px">
                            <a href="{{ route('admin_customer.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="box-body">
                        <div class="fields-group">

                            @if (sc_config('customer_lastname'))
                            <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.first_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="first_name" type="text" class="form-control" name="first_name" required
                                        value="{{ (old('first_name', $customer['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.last_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="last_name" type="text" class="form-control" name="last_name" required
                                        value="{{ (old('last_name', $customer['last_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('last_name'))
                                    <span class="help-block">{{ $errors->first('last_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="first_name" type="text" class="form-control" name="first_name" required
                                        value="{{ (old('first_name', $customer['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('first_name'))
                                    <span class="help-block">{{ $errors->first('first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config('customer_phone'))
                            <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="phone"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.phone') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="phone" type="text" class="form-control" name="phone" required
                                        value="{{ (old('phone', $customer['phone'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('phone'))
                                    <span class="help-block">{{ $errors->first('phone') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config('customer_postcode'))
                            <div class="form-group row {{ $errors->has('postcode') ? ' has-error' : '' }}">
                                <label for="postcode"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.postcode') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="postcode" type="text" class="form-control" name="postcode" required
                                        value="{{ (old('postcode', $customer['postcode'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('postcode'))
                                    <span class="help-block">{{ $errors->first('postcode') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.email') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="email" type="text" class="form-control" name="email" required
                                        value="{{ (old('email',$customer['email'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('email'))
                                    <span class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
    
                                </div>
                            </div>
    
                            @if (sc_config('customer_address2'))
                            <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                                <label for="address1"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.address1') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="address1" type="text" class="form-control" name="address1" required
                                        value="{{ (old('address1', $customer['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address1'))
                                    <span class="help-block">{{ $errors->first('address1') }}</span>
                                    @endif
    
                                </div>
                            </div>
    
                            <div class="form-group row {{ $errors->has('address2') ? ' has-error' : '' }}">
                                <label for="address2"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.address2') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="address2" type="text" class="form-control" name="address2" required
                                        value="{{ (old('address2', $customer['address2'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address2'))
                                    <span class="help-block">{{ $errors->first('address2') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('address1') ? ' has-error' : '' }}">
                                <label for="address1"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.address') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="address1" type="text" class="form-control" name="address1" required
                                        value="{{ (old('address1', $customer['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('address1'))
                                    <span class="help-block">{{ $errors->first('address1') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config('customer_country'))
                            @php
                            $country = old('country', $customer['country'] ?? '');
                            @endphp
    
                            <div class="form-group row {{ $errors->has('country') ? ' has-error' : '' }}">
                                <label for="country"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control country" style="width: 100%;" name="country">
                                        <option>__{{ trans('account.country') }}__</option>
                                        @foreach ($countries as $k => $v)
                                        <option value="{{ $k }}" {{ ($country == $k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                    <span class="help-block">
                                        {{ $errors->first('country') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config('customer_sex'))
                            @php
                            $sex = old('sex', $customer['sex'] ?? 0);
                            @endphp
                            <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                                <label
                                    class="col-sm-2 validate account_input {{ ($errors->has('sex'))?"input-error":"" }}">{{ trans('account.sex') }}:
                                </label>
                                <div class="col-sm-8">
                                <label class="radio-inline"><input value="0" type="radio" name="sex"
                                        {{ ($sex == 0)?'checked':'' }}> {{ trans('account.sex_women') }}</label>
                                <label class="radio-inline"><input value="1" type="radio" name="sex"
                                        {{ ($sex == 1)?'checked':'' }}> {{ trans('account.sex_men') }}</label>
                                </div>
                                @if ($errors->has('sex'))
                                <span class="help-block">
                                    {{ $errors->first('sex') }}
                                </span>
                                @endif
                            </div>
                            @endif
    
                            @if (sc_config('customer_birthday'))
                            <div class="form-group row {{ $errors->has('birthday') ? ' has-error' : '' }}">
                                <label for="birthday"
                                    class="col-sm-2 col-form-label text-md-right">
                                    {{ trans('account.birthday') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input type="date" id="birthday" data-date-format="YYYY-MM-DD" class="form-control"
                                        name="birthday" required
                                        value="{{ (old('birthday', $customer['birthday'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('birthday'))
                                    <span class="help-block">{{ $errors->first('birthday') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif

                            @if (sc_config('customer_group'))
                            <div class="form-group row {{ $errors->has('group') ? ' has-error' : '' }}">
                                <label for="group"
                                    class="col-sm-2 col-form-label text-md-right">{{ trans('account.group') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                    <input id="group" type="number" class="form-control" name="group" required
                                        value="{{ (old('group', $customer['group'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('group'))
                                    <span class="help-block">{{ $errors->first('group') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif


                            <div class="form-group  row {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-2  col-form-label text-md-right">{{ trans('customer.password') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                        <input type="text"   id="password" name="password" value="{{ old('password')??'' }}" class="form-control password" placeholder="" />
                                    </div>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                                <span class="help-block">
                                                     {{ trans('customer.admin.keep_password') }}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  ">
                                <label for="status" class="col-sm-2  col-form-label">{{ trans('customer.status') }}</label>
                                <div class="col-sm-8">
                                    <input class="input" type="checkbox" name="status"  {{ old('status',(empty($customer['status'])?0:1))?'checked':''}}>

                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- /.box-body -->

                    <div class="box-footer">
                            @csrf
                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-8">
                            <div class="btn-group pull-right">
                                <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                            </div>

                            <div class="btn-group pull-left">
                                <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-footer -->
                </form>

            </div>

            <div class="box">
                @if (!empty($addresses))
                    <div class="box-header with-border">
                        <h2 class="box-title">{{ trans('account.address_list') }}</h2>
                    </div>
                    @foreach($addresses as $address)
                        <div class="list">
                        @if (sc_config('customer_lastname'))
                        <b>{{ trans('account.first_name') }}:</b> {{ $address['first_name'] }}<br>
                        <b>{{ trans('account.last_name') }}:</b> {{ $address['last_name'] }}<br>
                        @else
                        <b>{{ trans('account.name') }}:</b> {{ $address['first_name'] }}<br>
                        @endif
                        
                        @if (sc_config('customer_phone'))
                        <b>{{ trans('account.phone') }}:</b> {{ $address['phone'] }}<br>
                        @endif
            
                        @if (sc_config('customer_postcode'))
                        <b>{{ trans('account.postcode') }}:</b> {{ $address['postcode'] }}<br>
                        @endif
            
                        @if (sc_config('customer_address2'))
                        <b>{{ trans('account.address1') }}:</b> {{ $address['address1'] }}<br>
                        <b>{{ trans('account.address2') }}:</b> {{ $address['address2'] }}<br>
                        @else
                        <b>{{ trans('account.address') }}:</b> {{ $address['first_address1'] }}<br>
                        @endif
            
                        @if (sc_config('customer_country'))
                        <b>{{ trans('account.country') }}:</b> {{ $countries[$address['country']] ?? $address['country'] }}<br>
                        @endif
            
                        <span class="btn">
                            <a title="{{ trans('account.addresses.edit') }}" href="{{ route('admin_customer.update_address', ['id' => $address->id]) }}"><i class="fa fa-edit"></i></a>
                        </span>
                        <span class="btn">
                            <a href="#" title="{{ trans('account.addresses.delete') }}" class="delete-address" data-id="{{ $address->id }}"><i class="fa fa-trash"></i></a>
                        </span>
                        @if ($address->id == $customer['address_id'])
                        <span class="btn" title="{{ trans('account.addresses.default') }}"><i class="fa fa-university" aria-hidden="true"></i></span>
                        @endif
                        </div>
                    @endforeach
                @endif
            </div>


        </div>
    </div>
@endsection

@push('styles')
<style>
    .list{
        padding: 5px;
        margin: 5px;
        border-bottom: 1px solid #dcc1c1;
    }
</style>
@endpush

@push('scripts')


<script type="text/javascript">
$(document).ready(function() {
    $('.select2').select2()
});
</script>

<script>
    $('.delete-address').click(function(){
      var r = confirm("{{ trans('account.confirm_delete') }}");
      if(!r) {
        return;
      }
      var id = $(this).data('id');
      $.ajax({
              url:'{{ route("admin_customer.delete_address") }}',
              type:'POST',
              dataType:'json',
              data:{id:id,"_token": "{{ csrf_token() }}"},
                  beforeSend: function(){
                  $('#loading').show();
              },
              success: function(data){
                if(data.error == 0) {
                  location.reload();
                }
              }
          });
    });
  </script>

@endpush
