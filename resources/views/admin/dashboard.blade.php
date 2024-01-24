@extends('layouts.admin')
@section('page_title', 'Dashboard')
@section('content')
@include('user.components.overview',['view' => 'wallet'])

<div class="container">
	<div class="col-12 mt-3">
		<h3>Your Current Quizzes</h3>
	</div>
	@if ($quizzes->count() > 0)
		<table class="table">
			<thead class="thead-light">
				<tr >
					<th class="" scope="col">Quiz</th>
					<th class=" d-none d-sm-none d-md-table-cell" scope="col">Starts</th>
					<th class=" d-none d-sm-none d-md-table-cell" scope="col">Ends</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col">Prize</th>
					<th class="d-none d-sm-none d-md-table-cell" scope="col"></th>
				</tr>
			</thead>
			<tbody>
				@foreach($quizzes as $quiz)
					<tr class="">
						<td class="">
							<strong>#{{$quiz->id}}</strong>
							<div class="col-12 p-0 d-md-none d-sm-block">
								<table class="table">
									<tr>
										<th>Prize</th>
										<td>₦{{number_format($quiz->prize)}}</td>
									</tr>
									<tr>
										<th>Start</th>
										<td>{{$quiz->start('jS M Y, h:ia')}}</td>
									</tr>
									<tr>
										<th>End</th>
										<td>{{$quiz->end('jS M Y, h:ia')}}</td>
									</tr>
									<tr>
										<td colspan="2">
											@if($quiz->action == "soon" )
												<a href="{{route('join.success',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">On Standby</a>
											@elseif($quiz->action == "very_soon" )
												<a href="{{route('join.success',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Starting Soon</a>
											@elseif($quiz->action == "start" )
												<a href="{{route('game.start',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Click to Start</a>
											@endif
										</td>
									</tr>
								</table>
							</div>
						</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->start('jS M Y, h:ia')}}</td>
						<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->end('jS M Y, h:ia')}}</td>
						<td class="d-none d-sm-none d-md-table-cell">₦{{number_format($quiz->prize)}}</td>
						<td class="d-none d-sm-none d-md-table-cell">
							@if($quiz->action == "soon" )
								<a href="{{route('join.success',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">On Standby</a>
							@elseif($quiz->action == "very_soon" )
								<a href="{{route('join.success',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Starting Soon</a>
							@elseif($quiz->action == "start" )
								<a href="{{route('game.start',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Click to Start</a>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="col-12 mb-4">
			<p>You have not joined any quiz yet.</p>
		</div>
	@endif
			
	<div class="col-12 mt-3">
		<h3>Recent Transactions</h3>
	</div>
	
	<table class="table">
		<thead class="thead-light">
			<tr >
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">#</th>
				<th class="" scope="col">Amount</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Purpose</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Method</th>
				<th class="" scope="col">Memo</th>
				<th class="" scope="col">Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach($transactions as $transaction)
				<tr class="">
					<td class=" d-none d-sm-none d-md-table-cell">{{$transaction->id}}</td>
					<td class="{{$transaction->type}}">₦{{number_format($transaction->amount)}} </td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$transaction->type}}</td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$transaction->method}}</td>
					<td class="">{{$transaction->description}}</td>
					<td class="">{{$transaction->trans_date('jS F,Y')}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
					
</div>

@endsection
