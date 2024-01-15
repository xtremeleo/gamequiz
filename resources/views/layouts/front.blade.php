<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Main CSS-->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color.css') }}">
<!--
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
-->
		
		<!-- Font-icon css-->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
		
		<title>@yield('page_title') | {{ config('app.name', 'Laravel') }}</title>
		<meta name="keywords" content="@yield('page_keywords')">
		<meta name="description" content="@yield('page_description')">
		<meta name="url" content="{{url()->current()}}">

		<!-- Open Graph / Facebook -->
		<meta property="og:type" content="website">
		<meta property="og:url" content="{{url()->current()}}">
		<meta property="og:title" content="@yield('page_title') - {{ config('app.name') }}">
		<meta property="og:description" content="@yield('page_description')">
		<meta property="og:image" content="{{url('assets/img/brand/meta_img.png')}}">

		<!-- Twitter -->
		<meta property="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="{{url()->current()}}">
		<meta property="twitter:title" content="@yield('page_title') - {{ config('app.name') }}">
		<meta property="twitter:description" content="@yield('page_description')">
		<meta property="twitter:image" content="{{url('assets/img/brand/meta_img.png')}}">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{url('assets/img/brand/favicon.png')}}"/>
		<link rel="apple-touch-icon" href="{{ asset('assets/img/brand/favicon.png') }}" />
	</head>
	<body>
		<style>
			.ndqz-nav .nav-item .nav-link{font-size: 17px; font-weight: 900;}
		</style>
		<section class="material-half-bg">
<!--			
			<div class="cover">
				<img src="{{asset('assets/img/theme/bg.png') }}" />
			</div>
-->
			
		</section>
		<div class="main-color-bg">
			<div class="container">
				<nav class="navbar navbar-expand-lg px-0 py-3">
					<a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('assets/img/brand/logo.png')}}" width="140px"></a>
	<!--
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="fa fa-bars black"></span>
					</button>
	-->
					<ul class="navbar-nav ndqz-nav ml-auto">
						@auth
							<li class="nav-item">
								<a class="nav-link" href="{{ route('dashboard')}}">Dashboard</a>
							</li>
						@else
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">Sign In</a>
							</li>
	<!--

							@if (Route::has('register'))
								<li class="nav-item">
									<a class="nav-link" href="{{ route('register') }}">Sign Up</a>
								</li>
							@endif
	-->
						@endauth
					</ul>
				</nav>
			</div>
		</div>
		
		
		@yield('content')
		<footer class="col-12 d-flex flex-column justify-content-center align-items-center mt-2">
			<p class="d-none d-sm-none d-md-block">&copy; 2021 - {{ date("Y")}} <strong class="px-3font-weight-bolder">Senorike Ltd</strong>  | <a class="mx-2" href="{{url('/')}}">Home</a> <a class="mx-2" href="{{route('home.about')}}">About</a> <a class="mx-2" href="{{route('home.privacy')}}">Privacy Policy</a> <a class="mx-2" href="{{route('home.contact')}}">Contact us</a> <img src="{{asset('assets/images/paystack-blue.png')}}" width="140px" /></p>
			
			<div class="d-block d-sm-block d-md-none"><center><img src="{{asset('assets/images/paystack.png')}}" width="80%" /></center></div>
			<p class="d-block d-sm-block d-md-none"><a class="mx-2" href="{{url('/')}}">Home</a> <a class="mx-2" href="{{route('home.about')}}">About</a> <a class="mx-2" href="{{route('home.privacy')}}">Privacy</a> <a class="mx-2" href="{{route('home.contact')}}">Contact us</a></p>
			<p class="d-block d-sm-block d-md-none"> &copy; 2021 - {{ date("Y")}} <strong>Senorike Ltd</strong> </p>
			
		</footer>
		
		<!-- Essential javascripts for application to work-->
		<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/main.js') }}"></script>
		<!-- The javascript plugin to display page loading on top-->
		<script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
		
		<!-- Scripts -->
		<!--
			<script src="{{ asset('js/app.js') }}" defer></script>
		-->
		
		<script type="text/javascript">
		  // Login Page Flipbox control
		  $('.login-content [data-toggle="flip"]').click(function() {
			$('.login-box').toggleClass('flipped');
			return false;
		  });
		</script>
		
	</body>
</html>

