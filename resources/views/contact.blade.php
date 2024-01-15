@extends('layouts.front')
@section('page_title', 'Contact us')
@section('page_description', 'Contact us for your complaints, feedback, suggestion and comments.')
@section('content')
		<section class="main-color-bg about-banner">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 d-flex flex-column justify-content-center align-items-center message">
				<h2>Contact us</h2>
			</div>
<!--
			<div class="cover"><img src="{{asset('assets/img/theme/bg.png') }}" /></div>
-->
		</section>
		<section id="upcoming_quizzes" class="container mt-2 p-0">
			<div class="col-12">
				<h2 class="my-4">Feel free</h2>
			</div>
			
			
			<div class="col-xl-10 col-lg-9 col-md-9 col-sm-12 p-0">
				<div class="col-12">
					<p style="font-size: 23px;">For all your enquiries, feedbacks, comments, suggestions, and complaints. </p>
				</div>
				<div class="col-12">
					<p style="font-size: 18px;">You can reach us at <strong>{{ config('app.email', 'info@nerdquiz.com.ng') }}</strong>, we shall response as soon as we receive it.</p>
				</div>
			</div>
		</section>
		
@endsection

