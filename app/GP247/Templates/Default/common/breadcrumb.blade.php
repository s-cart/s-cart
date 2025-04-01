{{-- breadcrumb --}}
@if (!empty($breadcrumbs) && count($breadcrumbs))
<section class="breadcrumbs-custom">
   
    <div class="breadcrumbs-custom-footer">
        <div class="container">
          <ul class="breadcrumbs-custom-path">
            <li><a href="{{ gp247_route_front('front.home') }}">{{ gp247_language_render('front.home') }}</a></li>
            @foreach ($breadcrumbs as $key => $item)
            @if (($key + 1) == count($breadcrumbs))
                <li class="active">{{ $item['title'] }}</li>
            @else
                <li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
            @endif
            @endforeach

          </ul>
        </div>
    </div>
</section>
@endif
{{-- //breadcrumb --}}