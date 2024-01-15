<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Main CSS-->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/join.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color.css') }}">

<!--
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
-->
		
		<!-- Font-icon css-->
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
		
		<!-- Favicon css-->
		 <link rel="icon" href="{{ asset('assets/img/brand/favicon.ico') }}" type="image/icon">

		<title>@yield('page_title') | {{ config('app.name', 'Laravel') }}</title>
	</head>
	<body>
		<section class="material-half-bg">
			<div class="cover"></div>
		</section>
		@if(Session::has('message'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<div class="container">
					{{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		@endif
		@if($errors->any())
		<div class="alert alert-danger">
			<div class="container">
				 <ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
		@endif
		@yield('content')
		
		<footer class="col-12 d-flex flex-column justify-content-center align-items-center">
			<p class="d-none d-sm-none d-md-block">{{config('app.name')}} &copy; {{ date("Y")}} | <a class="mx-2" href="{{url('/')}}">Home</a> <a class="mx-2" href="#">About</a> <a class="mx-2" href="#">Privacy Policy</a> <a class="mx-2" href="#">Contact us</a></p>
			<p class="d-block d-sm-block d-md-none"><a class="mx-2" href="{{url('/')}}">Home</a> <a class="mx-2" href="#">About</a> <a class="mx-2" href="#">Privacy</a> <a class="mx-2" href="#">Contact us</a></p>
			<p class="d-block d-sm-block d-md-none"> {{config('app.name')}} &copy; {{ date("Y")}}  </p>
			
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
		@stack('scripts')
		
	</body>
</html>

