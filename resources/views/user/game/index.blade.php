@extends('layouts.app')
@section('page_title', 'Current Quizzes')
@section('content')
@include('user.components.overview',['view' => 'quiz'])

<div class="container">
	<div class="col-12 mt-3">
		<h3>Current Quizzes</h3>
	</div>
	<table class="table">
		<thead class="thead-light">
			<tr >
				<th class="" scope="col">Quiz</th>
				<th class=" d-none d-sm-none d-md-table-cell" scope="col">Entry Fee</th>
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
									<td>₦{{number_format($quiz->prize)}} <i>(entry fee ₦{{number_format($quiz->entry_fee)}})</i></td>
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
										@if($quiz->action == "can_join" )
											<a href="{{route('join',['id' =>$quiz->id])}}" class="join btn btn-sm green-bg">Click to Join</a>
										@elseif($quiz->action == "cant_join" )
											<a href="{{route('join.closed',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Closed</a>
										@elseif($quiz->action == "already" )
											<a href="{{route('join.success',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Already Joined</a>
				<!--
											<p class="wine-red">Quiz starts in {{$quiz->minutes}} minutes</p>
				-->
										@elseif($quiz->action == "closed" )
											<a href="{{route('game',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Ended</a>
										@elseif($quiz->action == "start" )
											<a href="{{route('game.start',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Click to Start</a>
										@endif
									</td>
								</tr>
							</table>
						</div>
					</td>
					<td class=" d-none d-sm-none d-md-table-cell">₦{{number_format($quiz->entry_fee)}}</td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->start('jS M Y, h:ia')}}</td>
					<td class=" d-none d-sm-none d-md-table-cell">{{$quiz->end('jS M Y, h:ia')}}</td>
					<td class="d-none d-sm-none d-md-table-cell">₦{{number_format($quiz->prize)}}</td>
					<td class="d-none d-sm-none d-md-table-cell">
						@if($quiz->action == "can_join" )
							<a href="{{route('join',['id' =>$quiz->id])}}" class="join btn btn-sm green-bg">Click to Join</a>
						@elseif($quiz->action == "cant_join" )
							<a href="{{route('join.closed',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Closed</a>
						@elseif($quiz->action == "already" )
							<a href="{{route('join.success',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Already Joined</a>
<!--
							<p class="wine-red">Quiz starts in {{$quiz->minutes}} minutes</p>
-->
						@elseif($quiz->action == "closed" )
							<a href="{{route('game.ended',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Ended</a>
						@elseif($quiz->action == "start" )
							<a href="{{route('game.start',['id' =>$quiz->id])}}" class="join btn btn-sm wine-red-bg">Click to Start</a>
						@endif
														
					</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6">{{ $quizzes->links() }}</td>
			</tr>
		</tfoot>
	</table>
					
</div>

@endsection
