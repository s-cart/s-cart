
@php
/*
This view render notice for front-end
*/
@endphp

<!--notice-->
<div class="sc-notice">
   @if(Session::has('message'))
   <div class="alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {!! Session::get('message') !!}
   </div>
   @endif

   @if(Session::has('success'))
   <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {!! Session::get('success') !!}
   </div>
   @endif

   @if(Session::has('error'))
   <div class="alert alert-error alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    {!! Session::get('error') !!}
   </div>
   @endif

   @if(Session::has('warning'))
   <div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       {!! Session::get('warning') !!}
   </div>
   @endif

</div>
<!--//notice-->
