<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/color.css') }}" rel="stylesheet">
     <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/icon">

	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	
	 @stack('styles')
	 
    <title>@yield('page_title') | {{ config('app.name', 'Laravel') }}</title>
  </head>
  <body class="light-grey-bg ">
	  <header class="header main-color-bg" >
		  <div class="container">
			  <div class="row">
				  <div class="col p-2">
						<a class="navbar-brand white" href="{{ route('dashboard') }}"><img src="{{asset('assets/img/brand/black.png')}}" width="150px">
	<!--
							{{ config('app.name', 'Laravel') }}
	-->
						</a>
					</div>
					<div class="col p-2">
					  <div class="justify-content-end">
						  <a class="float-end btn btn-lg black p-0" href="{{ route('logout') }}"  onclick="event.preventDefault();  document.getElementById('logout-form').submit();"><i class="bi bi-power"></i> {{ __('sign out') }}</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
					  </div>
					</div>
			  </div>
			</div>
	  </header>

	<main class="main-content">
		@if(Session::has('message'))
			<div class="position-fixed col-md-3 col-sm-10" style="top: 15px; right: 15px;">
				<div class="alert alert-success" role="alert">
					{{ Session::get('message') }}
				</div>
			</div>
		@endif
		@if ($errors->any())
			<div class="position-fixed col-md-3 col-sm-10" style="top: 15px; right: 15px;">
				<div class="alert alert-danger" role="alert">
					<span class="alert-icon"><i class="ni ni-like-2"></i></span>
					<span class="alert-text">
						<strong>Errors!</strong>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</span>
				</div>
			</div>
		@endif
		
		@yield('content')
	</main>
	
	<div class="fixed-bottom d-block d-sm-block d-md-none mobile-menu">
		<div class="main-color-bg row p-3 ">
			<ul class="nav justify-content-between">
			  <li class="nav-item">
				<a class="nav-link black" href="{{route('wallet')}}"><i class="bi bi-wallet2"></i> Wallet</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link black" href="{{route('game')}}"><i class="bi bi-controller"></i> Quiz</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link black" href="{{route('account')}}"><i class="bi bi-person-fill"></i> Account</a>
			  </li>
			</ul>
		</div>
	
	</div>
	
		<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous"></script>
			  
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		@stack('scripts')
		
	</body>
</html>
