@extends($sc_templatePath.'.layout')

@section('block_main')
<section class="section section-xl bg-default text-md-left">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{ $msg??'' }}
            </div>
        </div>
    </div>
</section>
<!-- /.col -->
@endsection
