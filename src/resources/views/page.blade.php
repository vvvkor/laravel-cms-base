@prepend('scripts')
    <!--script src="{{ asset('js/v18-app.js') }}"></script-->
@endprepend

@push('scripts')
    <!--script src="{{ asset('js/v18-all.js') }}"></script-->
    <script src="{{ asset('js/app.js') }}" defer></script>
@endpush

@prepend('styles')
    <!--link href="{{ asset('css/v18.css') }}" rel="stylesheet"-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endprepend

@php ( $user = isset($user) ? $user : auth()->user() )
@php ( $lang = isset($lang) ? $lang : app()->getLocale() )
@php ( $nav = isset($nav) ? $nav : cms()->nav($lang) /* Cms::nav() */ )

<!DOCTYPE html>
<html lang="{{ isset($lang) ? $lang : 'en' }}" style="font-size:120%;">
    <head>
		<meta charset="utf-8">
        <!--title>@yield('title')</title-->
        <title>{{ isset($title) ? $title : (isset($sec) ? $sec->name : '') }}</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@stack('styles')
		@stack('scripts')
    </head>
    <body class="px-5 mx-auto" style="max-width:100em;">
		<section class="my-3">
			@component('cms::profile', ['user'=>@$user, 'table'=>@$table])
			@endcomponent
		</section>
	
		<div class="my-3">
			<h3 class="sr-only">{{ __('cms::common.nav') }}</h3>
			@section('nav')
				@component('cms::nav',['nav'=>@$nav,'sec'=>@$sec,'root'=>0])
				@endcomponent
			@show
		</div>

		@if(@$nav)
			@section('bread')
				<h3 class="sr-only">{{ __('cms::common.breadcrumbs') }}</h3>
				<nav class="">
					@component('cms::bread',['nav'=>$nav, 'sec'=>@$sec, 'table'=>@$table])
					@endcomponent
				</nav>
			@show
		@endif
		
		<main class="" id="main">
		
		@component('cms::alerts')
		@endcomponent

		@section('main')
			@if (@$sec)
				@component('cms::section',['sec'=>$sec])
				@endcomponent
			@endif

			@if(@$files)
				@component('cms::files',['files'=>$files])
				@endcomponent
			@endif

			@if(@$articles)
				@component('cms::articles',['articles'=>$articles])
				@endcomponent
			@endif
		@show
		</main>
		
    </body>
</html>