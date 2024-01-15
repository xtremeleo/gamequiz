@extends('layouts.app')
@section('page_title', 'Fund Wallet')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
	
	<div class="col-md-4 col-sm-10 main-color-bg">
		<h3 class="p-3">Fund Wallet</h3>
		<div class="col-12 p-3">
			 <form method="post" action="{{route('wallet.action')}}">
				 @csrf
				 <input type="hidden" name="action" value="fund" required />
				 
				<div class="form-group">
					<label for="amount">Amount</label>
					<input type="number" id="amount" class="form-control p-2 @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" min="100" required />
				</div>
				
				<div class="form-group mt-3 d-flex justify-content-between">
					<button type="submit" class="btn btn-primary" >Pay</button>
					<a href="{{route('wallet')}}" class="btn btn-secondary" >Back to wallet</a>
				</div>
			</form>
		</div>
	</div>
				
</div>
  
@endsection
