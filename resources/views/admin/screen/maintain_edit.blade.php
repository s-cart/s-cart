@extends('admin.layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h2 class="box-title">{{ $title_description??'' }}</h2>

                <div class="box-tools">
                    <div class="btn-group pull-right" style="margin-right: 5px">
                        <a href="{{ route('admin_maintain.index') }}" class="btn  btn-flat btn-default" title="List"><i
                                class="fa fa-list"></i><span class="hidden-xs"> {{trans('admin.back_list')}}</span></a>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">


                <div class="box-body">
                    <div class="fields-group">
                        @php
                        $descriptions = $maintain->descriptions->keyBy('lang')->toArray();
                        @endphp

                        @foreach ($languages as $code => $language)

                        <div class="form-group">
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-8">
                                <b>{{ $language->name }}</b>
                                {!! sc_image_render($language->icon,'20px','20px', $language->name) !!}
                            </div>
                        </div>

                        <div
                            class="form-group {{ $errors->has('descriptions.'.$code.'.maintain_content') ? ' has-error' : '' }}">
                            <label for="{{ $code }}__maintain_content"
                                class="col-sm-2 col-form-label">{{ trans('maintain.admin.description') }}</label>
                            <div class="col-sm-8">
                                <textarea id="{{ $code }}__maintain_content" class="editor"
                                    name="descriptions[{{ $code }}][maintain_content]">
                                        {{ old('descriptions.'.$code.'.maintain_content',($descriptions[$code]['maintain_content']??'')) }}
                                    </textarea>
                                @if ($errors->has('descriptions.'.$code.'.maintain_content'))
                                <span class="help-block">
                                    <i class="fa fa-info-circle"></i> {{ $errors->first('descriptions.'.$code.'.maintain_content') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        @endforeach

                    </div>
                </div>


                <!-- /.box-body -->

                <div class="box-footer">
                    @csrf
                    <div class="col-md-2">
                    </div>

                    <div class="col-md-8">
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
    </div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')
@include('admin.component.ckeditor_js')


<script type="text/javascript">
    $(document).ready(function() {
    $('.select2').select2()
});

</script>

<script type="text/javascript">
    $('textarea.editor').ckeditor(
    {
        filebrowserImageBrowseUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}?type=content',
        filebrowserImageUploadUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=content&_token={{csrf_token()}}',
        filebrowserBrowseUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}?type=Files',
        filebrowserUploadUrl: '{{ route('admin.home').'/'.config('lfm.url_prefix') }}/upload?type=file&_token={{csrf_token()}}',
        filebrowserWindowWidth: '900',
        filebrowserWindowHeight: '500'
    }
);
</script>

@endpush