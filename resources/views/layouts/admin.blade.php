<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
	  
		<title>{{ config('app.name', 'Laravel') }}</title>
		<!-- Styles -->
		<link href="{{ asset('adm/css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('adm/css/color.css') }}" rel="stylesheet">
		
		<!-- Scripts -->
<!--
		<script src="{{ asset('adm/js/app.js') }}" defer></script>
-->
    
		@stack('styles')
		
	</head>
	<body>
		<style>
			.navbar-brand {color:#2E2B2E!important;}
			.navbar {border-bottom: 4px solid #9620cc; padding: .5rem .5rem 0rem .5rem; margin-bottom: 10px;}
			.nav-link { padding:8px 27px !important; font-size: 20px;}
			.nav-link.active {color:#FFFFFF!important; background-color: #9620cc; border-radius: 15px 15px 0px 0px;}
		</style>
		
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand font-weight-bold" href="#">
				BNK Admin
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item"><a class="nav-link {{($urlName == 'Home' ? 'active' : '' )}}" href="{{route('admin.index')}}">Home</a></li>
					<li class="nav-item"><a class="nav-link  {{($urlName == 'Users' ? 'active' : '' )}}" href="{{route('admin.users')}}">Users</a></li>
					<li class="nav-item dropdown">
						<a class="nav-link  {{($urlName == 'Settings' ? 'active' : '' )}} dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Settings
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
														 document.getElementById('logout-form').submit();"><i class="ni ni-user-run"></i> <span>Logout</span></a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		
	  <div class="container">
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
			@if ($errors->any())
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<span class="alert-icon"><i class="ni ni-like-2"></i></span>
					<span class="alert-text">
						<strong>Errors!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</span>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif
		@yield('content')
	  </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	@stack('scripts')
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
