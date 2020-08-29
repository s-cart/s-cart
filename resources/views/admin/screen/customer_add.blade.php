@extends('admin.layout')

@section('main')
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
                <div class="card-header with-border">
                    <h2 class="card-title">{{ $title_description??'' }}</h2>

                    <div class="card-tools">
                        <div class="btn-group float-right mr_5">
                            <a href="{{ route('admin_customer.index') }}" class="btn  btn-flat btn-default" title="List"><i class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"  enctype="multipart/form-data">


                    <div class="card-body">
                            @if (sc_config('customer_lastname'))
                            <div class="form-group row {{ $errors->has('reg_first_name') ? ' text-red' : '' }}">
                                <label for="first_name"
                                    class="col-sm-2 col-form-label">{{ trans('account.first_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_first_name" type="text" class="form-control" name="reg_first_name"
                                        value="{{ (old('reg_first_name', $customer['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_first_name'))
                                    <span class="form-text">{{ $errors->first('reg_first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('reg_last_name') ? ' text-red' : '' }}">
                                <label for="reg_last_name"
                                    class="col-sm-2 col-form-label">{{ trans('account.last_name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_last_name" type="text" class="form-control" name="reg_last_name"
                                        value="{{ (old('reg_last_name', $customer['last_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_last_name'))
                                    <span class="form-text">{{ $errors->first('reg_last_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('reg_first_name') ? ' text-red' : '' }}">
                                <label for="reg_first_name"
                                    class="col-sm-2 col-form-label">{{ trans('account.name') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_first_name" type="text" class="form-control" name="reg_first_name"
                                        value="{{ (old('reg_first_name', $customer['first_name'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_first_name'))
                                    <span class="form-text">{{ $errors->first('reg_first_name') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config('customer_name_kana'))
                            <div class="form-group row {{ $errors->has('reg_first_name_kana') ? ' text-red' : '' }}">
                                <label for="first_name_kana"
                                    class="col-sm-2 col-form-label">{{ trans('account.first_name_kana') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_first_name_kana" type="text" class="form-control" name="reg_first_name_kana"
                                        value="{{ (old('reg_first_name_kana', $customer['first_name_kana'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_first_name_kana'))
                                    <span class="form-text">{{ $errors->first('reg_first_name_kana') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            <div class="form-group row {{ $errors->has('reg_last_name_kana') ? ' text-red' : '' }}">
                                <label for="reg_last_name_kana"
                                    class="col-sm-2 col-form-label">{{ trans('account.last_name_kana') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_last_name_kana" type="text" class="form-control" name="reg_last_name_kana"
                                        value="{{ (old('reg_last_name_kana', $customer['last_name_kana'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_last_name_kana'))
                                    <span class="form-text">{{ $errors->first('reg_last_name_kana') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif


                            @if (sc_config('customer_phone'))
                            <div class="form-group row {{ $errors->has('reg_phone') ? ' text-red' : '' }}">
                                <label for="reg_phone"
                                    class="col-sm-2 col-form-label">{{ trans('account.phone') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="phone" type="text" class="form-control" name="reg_phone"
                                        value="{{ (old('reg_phone', $customer['phone'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_phone'))
                                    <span class="form-text">{{ $errors->first('reg_phone') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config('customer_postcode'))
                            <div class="form-group row {{ $errors->has('reg_postcode') ? ' text-red' : '' }}">
                                <label for="reg_postcode"
                                    class="col-sm-2 col-form-label">{{ trans('account.postcode') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_postcode" type="text" class="form-control" name="reg_postcode"
                                        value="{{ (old('reg_postcode', $customer['postcode'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('reg_postcode'))
                                    <span class="form-text">{{ $errors->first('reg_postcode') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
                            <div class="form-group row {{ $errors->has('reg_email') ? ' text-red' : '' }}">
                                <label for="reg_email"
                                    class="col-sm-2 col-form-label">{{ trans('account.email') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_email" type="text" class="form-control" name="reg_email"
                                        value="{{ (old('reg_email',$customer['email'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('reg_email'))
                                    <span class="form-text">{{ $errors->first('reg_email') }}</span>
                                    @endif
    
                                </div>
                            </div>
    
                            @if (sc_config('customer_address2'))
                            <div class="form-group row {{ $errors->has('reg_address1') ? ' text-red' : '' }}">
                                <label for="reg_address1"
                                    class="col-sm-2 col-form-label">{{ trans('account.address1') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_address1" type="text" class="form-control" name="reg_address1"
                                        value="{{ (old('reg_address1', $customer['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_address1'))
                                    <span class="form-text">{{ $errors->first('reg_address1') }}</span>
                                    @endif
    
                                </div>
                            </div>
    
                            <div class="form-group row {{ $errors->has('reg_address2') ? ' text-red' : '' }}">
                                <label for="reg_address2"
                                    class="col-sm-2 col-form-label">{{ trans('account.address2') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_address2" type="text" class="form-control" name="reg_address2"
                                        value="{{ (old('reg_address2', $customer['address2'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_address2'))
                                    <span class="form-text">{{ $errors->first('reg_address2') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @else
                            <div class="form-group row {{ $errors->has('reg_address1') ? ' text-red' : '' }}">
                                <label for="reg_address1"
                                    class="col-sm-2 col-form-label">{{ trans('account.address') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_address1" type="text" class="form-control" name="reg_address1"
                                        value="{{ (old('reg_address1', $customer['address1'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_address1'))
                                    <span class="form-text">{{ $errors->first('reg_address1') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif
    
    
                            @if (sc_config('customer_country'))
                            @php
                            $country = old('reg_country', $customer['country'] ?? '');
                            @endphp
    
                            <div class="form-group row {{ $errors->has('reg_country') ? ' text-red' : '' }}">
                                <label for="reg_country"
                                    class="col-sm-2 col-form-label">{{ trans('account.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control reg_country" style="width: 100%;" name="reg_country">
                                        <option>__{{ trans('account.country') }}__</option>
                                        @foreach ($countries as $k => $v)
                                        <option value="{{ $k }}" {{ ($country == $k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('reg_country'))
                                    <span class="form-text">
                                        {{ $errors->first('reg_country') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
    
                            @if (sc_config('customer_sex'))
                            @php
                            $sex = old('reg_sex', $customer['sex'] ?? 0);
                            @endphp
                            <div class="form-group{{ $errors->has('reg_sex') ? ' text-red' : '' }}">
                                <label
                                    class="col-sm-2 validate account_input {{ ($errors->has('reg_sex'))?"input-error":"" }}">{{ trans('account.sex') }}:
                                </label>
                                <div class="col-sm-8">
                                <label class="radio-inline"><input value="0" type="radio" name="reg_sex"
                                        {{ ($sex == 0)?'checked':'' }}> {{ trans('account.sex_women') }}</label>
                                <label class="radio-inline"><input value="1" type="radio" name="reg_sex"
                                        {{ ($sex == 1)?'checked':'' }}> {{ trans('account.sex_men') }}</label>
                                </div>
                                @if ($errors->has('reg_sex'))
                                <span class="form-text">
                                    {{ $errors->first('reg_sex') }}
                                </span>
                                @endif
                            </div>
                            @endif
    
                            @if (sc_config('customer_birthday'))
                            <div class="form-group row {{ $errors->has('reg_birthday') ? ' text-red' : '' }}">
                                <label for="reg_birthday"
                                    class="col-sm-2 col-form-label">
                                    {{ trans('account.birthday') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input type="date" id="reg_birthday" data-date-format="YYYY-MM-DD" class="form-control"
                                        name="reg_birthday"
                                        value="{{ (old('reg_birthday', $customer['birthday'] ?? ''))}}">
                                    </div>
                                    @if($errors->has('reg_birthday'))
                                    <span class="form-text">{{ $errors->first('reg_birthday') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif

                            @if (sc_config('customer_group'))
                            <div class="form-group row {{ $errors->has('reg_group') ? ' text-red' : '' }}">
                                <label for="reg_group"
                                    class="col-sm-2 col-form-label">{{ trans('account.group') }}</label>
    
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                    <input id="reg_group" type="number" class="form-control" name="reg_group"
                                        value="{{ (old('reg_group', $customer['group'] ?? ''))}}">
                                    </div>
    
                                    @if($errors->has('reg_group'))
                                    <span class="form-text">{{ $errors->first('reg_group') }}</span>
                                    @endif
    
                                </div>
                            </div>
                            @endif


                            <div class="form-group  row {{ $errors->has('reg_password') ? ' text-red' : '' }}">
                                <label for="password" class="col-sm-2  col-form-label">{{ trans('customer.password') }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-pencil-alt"></i></span>
                                        </div>
                                        <input type="text"   id="reg_password" name="reg_password" value="{{ old('reg_password')??'' }}" class="form-control reg_password" placeholder="" />
                                    </div>
                                        @if ($errors->has('reg_password'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('reg_password') }}
                                            </span>
                                        @else
                                            @if ($customer)
                                                <span class="form-text">
                                                     {{ trans('customer.admin.keep_password') }}
                                                 </span>
                                            @endif
                                        @endif
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="reg_status" class="col-sm-2  col-form-label">{{ trans('customer.status') }}</label>
                                <div class="col-sm-8">
                                    <input class="input" type="checkbox" name="reg_status"  {{ old('reg_status',(empty($customer['status'])?0:1))?'checked':''}}>

                                </div>
                            </div>
                    </div>



                    <!-- /.card-body -->

                    <div class="card-footer row">
                            @csrf
                        <div class="col-sm-2">
                        </div>

                        <div class="col-sm-8">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                            </div>

                            <div class="btn-group pull-left">
                                <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
                            </div>
                        </div>
                    </div>

                    <!-- /.card-footer -->
                </form>

            </div>

            <div class="card">
                @if (!empty($addresses))
                    <div class="card-header with-border">
                        <h2 class="card-title">{{ trans('account.address_list') }}</h2>
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
