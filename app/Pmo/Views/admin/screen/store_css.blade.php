@extends($templatePathAdmin.'layout')

@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <h2 class="card-title">{{ $title_description??'' }}</h2>
                @if (function_exists('sc_get_list_code_store') && count(sc_get_list_code_store()))
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        {{ sc_language_render('admin.select_store') }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-left p-0">
                    
                    @foreach (sc_get_list_code_store() as $id => $code)
                    <a href="{{ sc_route_admin('admin_store_css.index', ['store_id' => $id]) }}" class="dropdown-item  {{ ($storeId == $id) ? 'disabled active':'' }}">
                        <div class="hover">
                        {{ $code }}
                        </div>
                    </a>
                    @endforeach
                    </div>
                </ul>
                @endif
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ $url_action }}" method="post" accept-charset="UTF-8" class="form-horizontal" id="form-main"
                enctype="multipart/form-data">
                <input type="hidden" name="template" value="{{ $template }}">
                <input type="hidden" name="storeId" value="{{ $storeId }}">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h2>{{ sc_language_render('store.admin.css') }}</h2>
                            <div class="form-group row {{ $errors->has('css') ? 'text-red' : '' }}">
                                <div class="col-sm-12">
                                        <textarea  id="css" name="css">{{ old('css',$css??'') }}</textarea>
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
<link rel="stylesheet" href="{{ sc_file('admin/plugin/mirror/doc/docs.css')}}">
<link rel="stylesheet" href="{{ sc_file('admin/plugin/mirror/lib/codemirror.css')}}">
@endpush

@push('scripts')
<script src="{{ sc_file('admin/plugin/mirror/lib/codemirror.js')}}"></script>
<script src="{{ sc_file('admin/plugin/mirror/mode/css/css.js')}}"></script>
<script>
    window.onload = function() {
      editor = CodeMirror(document.getElementById("css"), {
        mode: "text/html",
        value: document.documentElement.innerHTML
      });
    };
    var editor = CodeMirror.fromTextArea(document.getElementById("css"), {
      lineNumbers: true,
      styleActiveLine: true,
      matchBrackets: true
    });
  </script>
@endpush