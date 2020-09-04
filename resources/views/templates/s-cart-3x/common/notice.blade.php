<!--main right-->
<div class="col-12">
    <div class="sc-notice">
        @if(Session::has('message') || Session::has('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('message') !!}
            {!! Session::get('status') !!}
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('success') !!}
        </div>
        @endif

        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('error') !!}
        </div>
        @endif

        @if(Session::has('warning'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! Session::get('warning') !!}
        </div>
        @endif

    </div>
</div>
<!--//main right-->
