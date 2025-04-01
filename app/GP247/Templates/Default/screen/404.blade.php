@extends($GP247TemplatePath.'.layout')

@section('block_main')
<div class="error-page min-h-screen flex items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-800">404</h1>
        <h2 class="text-2xl font-semibold text-gray-600 mt-4">{{ gp247_language_render('front.404') }}</h2>
        <p class="text-gray-500 mt-4 mb-8">{{ $msg ?? '' }}</p>
        <a href="{{ gp247_route_front('front.home') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
            {{ gp247_language_render('front.backhome') }}
        </a>
    </div>
</div>
@endsection
