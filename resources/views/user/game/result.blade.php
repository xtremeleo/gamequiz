@extends('layouts.join')
@section('page_title', 'Quizzes for today')
@section('content')
<section class="join-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	<div class="join-box">
		<form id="paymentForm" class="join-form">
				<h4 class="join-head">QUIZ #{{$quiz->id}}</h4>
<!--
				<div style="position: absolute; top: -5px; right: -5px;">
					<div class="wine-red-bg" style="width: 100px; height: 100px; border-radius: 50%; padding: 30px;">
						<h4 class="white">FAILED</h4>
					 </div>
				</div>
-->
				<div class="form-group">
					<label class="control-label">STARTS</label>
					<p>{{$quiz->start(' jS M Y H:ia')}}</p>
				</div>
				<div class="form-group">
					<label class="control-label">ENDS</label>
					<p>{{$quiz->end(' jS M Y H:ia')}}</p>
				</div>
				<div class="form-group">
					<label class="control-label">CASH PRIZE</label>
					<p>₦{{number_format($quiz->prize)}}</p>
				</div>
				<div class="form-group">
					<label class="control-label">POSITION <span class="wine-red">(SCORES)</span></label>
					<p>{{$entry->position }} <span class="wine-red">({{$entry->score}} / {{ count($quiz->questions()) }})</span></p>
				</div>
				<div class="form-group btn-container d-flex justify-content-between">
					<a class="btn btn-success col-4" href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
					<a class="btn btn-danger col-7" href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a>
				</div>
				<div class="form-group mt-2">
					<div class="utility">
						<p class="semibold-text mb-2">
<!--
							<a href="{{route('dashboard')}}">Dashboard</a>
-->
						</p>
					</div>
				</div>
			</form>
				
	</div>
</section>
