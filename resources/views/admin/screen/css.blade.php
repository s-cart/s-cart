@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <h2 class="card-title">{{ $title_description??'' }}</h2>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">


                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row {{ $errors->has('css') ? ' text-red' : '' }}">
                                <label for="css" class="col-sm-2 col-form-label">{{ trans('store.css') }}</label>
                                <div class="col-sm-8">
                                        <textarea class="form-control" rows="10" id="css" name="css">{{ old('css',$css??'') }}</textarea>
                                        @if ($errors->has('css'))
                                            <span class="form-text">
                                                <i class="fa fa-info-circle"></i> {{ $errors->first('css') }}
                                            </span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- /.card-body -->

                <div class="card-footer row">
                    @csrf
                    <div class="col-md-2">
                    </div>

                    <div class="col-md-8">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary">{{ trans('admin.submit') }}</button>
                        </div>

                        <div class="btn-group float-left">
                            <button type="reset" class="btn btn-warning">{{ trans('admin.reset') }}</button>
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