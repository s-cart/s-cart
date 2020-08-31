@extends($sc_templatePath.'.layout')

@section('main')
    <section >
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-danger text-center">
                   <h1>{{ $msg??'' }}</h1>
                </div>
                </div>
            </div>
        </section>
<!-- /.col -->
@endsection
