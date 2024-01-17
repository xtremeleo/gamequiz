@extends('layouts.join')
@section('page_title', 'Join Quiz #'.$quiz->id)
@section('content')
<section class="join-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	
	<div class="join-box">
		<form id="paymentForm" class="join-form" method="post" action="{{ route('join.action', ['id' => $quiz->id ]) }}">
				@csrf
				<input type="hidden" name="action" value="joinquiz"  />
				<h4 class="join-head">JOIN QUIZ #{{$quiz->id}}</h4>
				
				<div class="form-group">
					<label class="control-label">STARTS</label>
					<p>{{$quiz->start(' jS M Y h:ia')}}</p>
				</div>
				<div class="form-group">
					<label class="control-label">ENDS</label>
					<p>{{$quiz->end(' jS M Y h:ia')}}</p>
				</div>
				<div class="form-group">
					<label class="control-label">CASH PRIZE</label>
					<p>₦{{number_format($quiz->prize)}}</p>
				</div>
				<div class="form-group btn-container">
<!--
					<button class="btn btn-primary btn-block" onclick="payWithPaystack()"><i class="fa fa-money fa-lg fa-fw"></i>PAY WITH PAYSTACK</button>
-->
					<button class="btn btn-primary btn-block" ><i class="fa fa-lock fa-lg fa-fw"></i>JOIN NOW</button>
				</div>
				<div class="form-group mt-2">
					<div class="utility">
						<p class="semibold-text mb-2">
							<a href="{{route('dashboard')}}">Dashboard</a>
						</p>
					</div>
				</div>
			</form>
				
	</div>
</section>

             
                
                
    
@endsection
@push('scripts')
@endpush
