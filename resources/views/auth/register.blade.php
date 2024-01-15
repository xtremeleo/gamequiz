@extends('layouts.auth')
@section('page_title', 'Sign Up')
@section('content')
<section class="register-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	
	<div class="register-box">
		<form class="register-form"  method="POST" action="{{ route('register') }}">
			@csrf
			
			<h4 class="register-head">SIGN UP</h4>
			
			<div class="form-group">
				<label for="name" class="control-label">{{ __('Name') }}</label>
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
				@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="mobile" class="control-label">{{ __('Mobile') }}</label>
				<input id="mobile" type="tel" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">
				@error('mobile')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="email" class="control-label">{{ __('E-Mail Address') }}</label>
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="password" class="control-label">{{ __('Password') }}</label>
				<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<div class="form-group">
				<label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
			</div>
			
			<div class="form-group btn-container">
				<button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN UP</button>
			</div>
			
			<div class="form-group mt-2">
				<div class="utility">
					<p class="semibold-text mb-2">
						<a href="{{route('login')}}">Already have account? Sign in</a>
					</p>
				</div>
			</div>
		</form>
	</div>
</section>
@endsection
