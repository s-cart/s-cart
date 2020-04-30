@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="col-md-12">
                <div class="process-alert">
                    {!! $title !!}
                </div>
                <hr>
            </div>

            <form action="{{ route('admin_plugin.process_import') }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="import-product" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="fields-group">
                        <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
                            <label for="image" class="col-sm-2 col-form-label">
                            </label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input accept="zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed" type="file" required="required" name="file" class="form-control" placeholder="" >
                                    <div class="btn input-group-addon button-upload">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> {{ trans('plugin.import_submit') }}
                                    </div>
                                </div>
                                <div>
                                    @if ($errors->has('file'))
                                    <span class="help-block">
                                        <i class="fa fa-info-circle"></i> {{ $errors->first('file') }}
                                    </span>
                                    @else
                                    <span class="help-block">
                                        <i class="fa fa-info-circle"></i> {!! trans('plugin.import_note') !!}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- /.box-footer -->
            </form>  
        </div>
    </div>
</div>


@endsection

@push('styles')
<style>
    .button-upload, .button-upload:hover,
    .button-upload-des, .button-upload-des:hover{
        background: #3c8dbc !important;
        color: #fff;
    }
</style>
@endpush

@push('scripts')
    <script>
        $('.button-upload').click(function(){
            $('#loading').show();
            $('#import-product').submit();
        });
        $('.button-upload-des').click(function(){
            $('#loading').show();
            $('#import-product-des').submit();
        });

    </script>
@endpush