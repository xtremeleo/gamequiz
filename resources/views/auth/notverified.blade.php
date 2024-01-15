@extends('layouts.auth')
@section('page_title', 'Verification Needed')
@section('content')
<section class="login-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	
	<div class="login-box">
		<form class="login-form d-flex flex-column justify-content-between" action="{{ route('verify.send') }}">
			@csrf
			<h4 class="login-head">EMAIL VERIFICATION</h4>
			<div class="form-group">
				<h4>Hey {{Auth()->user()->name}}</h4>
				<p>Please click the button below to verify your email.</p>
			</div>
			<div class="form-group">
				@if(Session::has('message'))
					<div class="col-12s">
						<div class="alert alert-success" role="alert">
							{{ Session::get('message') }}
						</div>
					</div>
				@endif
			</div>
			<div class="form-group btn-container">
				<button class="btn btn-primary btn-block"><i class="fa fa-envelope fa-lg fa-fw"></i>SEND</button>
			</div>
		</form>
				
	</div>
</section>
                
                
                
    
@endsection
