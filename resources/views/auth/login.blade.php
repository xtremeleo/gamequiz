@extends('layouts.auth')
@section('page_title', 'Sign In')
@section('content')
<section class="login-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	
	<div class="login-box">
		<form class="login-form" method="post" action="{{ route('login') }}">
				@csrf
				<h4 class="login-head">SIGN IN</h4>
				<div class="form-group">
					<label class="control-label">EMAIL</label>
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="form-group">
					<label class="control-label">PASSWORD</label>
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
					@error('password')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
				</div>
				<div class="form-group">
					<div class="utility">
						<div class="animated-checkbox">
							<label >
								<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<span class="label-text">Stay Signed in</span>
							</label>					
						</div>
						<p class="semibold-text mb-2">
							@if (Route::has('password.request'))
								<a href="#" data-toggle="flip">Forgot Password ?</a>
							@endif
						</p>
					</div>
				</div>
				<div class="form-group btn-container">
					<button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
				</div>
				<div class="form-group mt-2">
					<div class="utility">
						<p class="semibold-text mb-2">
							@if (Route::has('password.request'))
								<a href="{{route('register')}}">Sign up for an account?</a>
							@endif
						</p>
					</div>
				</div>
			</form>
				
		<form class="forget-form" method="post" action="{{route('password.request')}}">
		  <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
		  <div class="form-group">
			<label class="control-label">EMAIL</label>
			<input class="form-control" type="text" placeholder="Email">
		  </div>
		  <div class="form-group btn-container">
			<button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
		  </div>
		  <div class="form-group mt-3">
			<p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
		  </div>
		</form>
	</div>
</section>
                
                
                
    
@endsection
