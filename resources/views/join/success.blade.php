@extends('layouts.join')
@section('page_title', 'Joined Quiz #'.$quiz->id)
@section('content')
<section class="join-content">
	<div class="logo">
<!--
		<h1>Welcome</h1>
-->
		<img src="{{asset('assets/img/brand/logo.png')}}" width="200px">
	</div>
	<div class="success-box">
		<div class="join-form">
				<h4 class="join-head">QUIZ #{{$quiz->id}}</h4>
				<div style="position: absolute; top: -30px; right: -20px;">
					 <img src="{{asset('assets/img/theme/paid.png')}}" width="130px"/>
				</div>
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
				<div class="form-group">
					<label class="control-label">ENTRY FEE</label>
					<p>₦{{number_format($quiz->entry_fee)}}</p>
				</div>
				<div class="form-group">
					<label class="control-label">PAID ON</label>
					<p>{{$entry->created_at->format('jS M Y h:ia')}}</p>
				</div>
				<div class="form-group btn-container d-flex justify-content-between">
					<a class="btn btn-success col-4" href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
					<a class="btn btn-danger col-7" href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a>
				</div>
				<div class="form-group mt-2">
					<div class="utility">
						<p class="semibold-text mb-2">
							
						</p>
					</div>
				</div>
			</div>
				
	</div>
</section>

             
                
                
    
@endsection
@push('scripts')

@endpush
