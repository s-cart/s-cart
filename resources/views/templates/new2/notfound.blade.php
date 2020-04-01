@extends($templatePath.'.layout')

@section('main')
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
            </div>
            <div class="col-12">
                {{ $msg??'' }}
            </div>
        </div>
    </div>
</section>
<!-- /.col -->
@endsection
