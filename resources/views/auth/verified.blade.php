@extends('layouts.auth')
@section('page_title', 'Verification Done')
@section('content')
<section class="login-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	
	<div class="login-box">
		<div class="login-form d-flex flex-column justify-content-between" >
			<h4 class="login-head">EMAIL VERIFIED</h4>
			<div class="form-group">
				<h4>Hey {{$user->name}}</h4>
				<p>Your email is now verified, you can now login. </p>
			</div>
			<div class="form-group btn-container">
				<a class="btn btn-primary btn-block" href="{{route('dashboard')}}"><i class="fa fa-lock fa-lg fa-fw"></i>Login</a>
			</div>
		</div>
				
	</div>
</section>
                
                
                
    
@endsection
